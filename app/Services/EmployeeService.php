<?php

namespace App\Services;

use App\Repositories\EmployeeRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;


class EmployeeService
{

    const COUNT = 20;

    protected EmployeeRepository $employeeRepository;
    private DepartmentService $departmentService;
    private UserService $userService;

    public function __construct(EmployeeRepository $employeeRepository,
                                UserService $userService,
                                DepartmentService $departmentService)
    {
        $this->employeeRepository = $employeeRepository;
        $this->departmentService = $departmentService;
        $this->userService = $userService;
    }


    public function getEmployeesByManager($filters = []): Collection
    {
        return $this->employeeRepository->getEmployees([], [], $filters)
            ->get();
    }

    public function getEmployeesByManagerWithPaginate($filters = [], $manager_id = null): LengthAwarePaginator
    {
        $filters['manager_id'] = $manager_id ?? optional(auth()->user()->manager)->id;

        $conditions['manager_id'] = $filters['manager_id'];
        return $this->employeeRepository->getEmployees($conditions, [], $filters)
            ->paginate(self::COUNT);
    }

    public function getCreateEmployeeData(): array
    {
        $departments = $this->departmentService->getAllDepartments();
        return [
            'departments' => $departments,
//            'managers' => $managers,
        ];
    }

    public function createEmployee($request, $manager_id = null)
    {
        $imagePath = null;
        $manager_id = $manager_id ?? optional(auth()->user()->manager)->id;
        $request['password']=  Hash::make($request['password']);
        $user =  $this->userService->createUser(array_merge($request, ['role' => 'employee']));

        if (isset($request['image'])) {
            $file = $request['image'];
            $imagePath = $this->saveImage($file);
        }
        $this->employeeRepository->create(array_merge($request,[
            'user_id'       => $user->id,
            'manager_id'    => $manager_id,
            'image'         => $imagePath
        ]));
    }

    public function getUpdateEmployeeData($employee): array
    {
        if (!($employee instanceof Model)){
            $employee = $this->employeeRepository->get($employee, [], 'id', ['department']);
        }
        if (!(optional(auth()->user()->manager)->id == $employee->manager_id)){
            throw new \Exception(' Permission denied!');
        }
        $departments = $this->departmentService->getAllDepartments();
        return [
            'departments' => $departments,
            'employee' => $employee,
        ];
    }

    public function updateEmployee($request, $employee)
    {

        if (!($employee instanceof Model)){
            $employee = $this->employeeRepository->get($employee, [], 'id', ['department']);
        }
        if (!(optional(auth()->user()->manager)->id == $employee->manager_id)){
            throw new \Exception(' Permission denied!');
        }

        $imagePath = null;
        $this->userService->updateUser(array_merge($request, ['role' => 'employee']),
            $employee->user);

        if (isset($request['image'])) {
            $file = $request['image'];
            $imagePath = $this->saveImage($file);
        }
        $employeeData = (!$imagePath) ? $request : array_merge($request,[
            'image' => $imagePath
        ]);
        $this->employeeRepository->update($employee->id, $employeeData);
    }

    public function deleteEmployee($employee)
    {
        if (!($employee instanceof Model)){
            $employee = $this->employeeRepository->get($employee, [], 'id', ['department']);
        }
        if (!(optional(auth()->user()->manager)->id == $employee->manager_id)){
            throw new \Exception(' Permission denied!');
        }

        $employee->tasks()->delete();
        $employee->delete();
        $this->userService->deleteUser($employee->user);
    }

    protected function saveImage($file): string
    {
        $path = 'employees/photos/'. time().'_'. Str::random(4);
        Storage::put('/public/' . $path, file_get_contents($file->getRealPath()));
        return '/storage/' . $path;
    }

}
