<?php

namespace App\Services;

use App\Models\Department;
use App\Repositories\DepartmentRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

class DepartmentService
{

    const COUNT = 20;
    protected $departmentRepository;

    public function __construct(DepartmentRepository $departmentRepository)
    {
        $this->departmentRepository = $departmentRepository;
    }

    public function getAllDepartments($filters = []): Collection
    {
        return $this->departmentRepository->getDepartments([], [], $filters)
            ->get();
    }

    public function getDepartments($filters = []): LengthAwarePaginator
    {
        return $this->departmentRepository->getDepartments([], ['employees'], $filters)
            ->withCount('employees')->withSum('employees', 'salary')
            ->paginate(self::COUNT);
    }

    public function createDepartment($request)
    {
        $this->departmentRepository->create($request);
    }

    public function getUpdateDepartmentData($department)
    {
        if (!($department instanceof Model)){
            $department = $this->departmentRepository->get($department, [], 'id', ['department']);
        }

        return [
            'department' => $department,
        ];
    }

    public function updateDepartment($request, $department)
    {
        $this->departmentRepository->update($department->id, $request);
    }

    /**
     * @throws \Exception
     */
    public function deleteDepartment($department)
    {
        if (!($department instanceof Model)){
            $department = $this->departmentRepository->get($department, [], 'id', ['department']);
        }

        if (count($department->employees) == 0){

            $department->delete();
        }
        throw new \Exception('Delete Failed!, Department has at least one employee.');

    }
}
