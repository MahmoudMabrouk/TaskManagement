<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use App\Models\Employee;
use App\Services\DepartmentService;
use App\Services\EmployeeService;
use App\Services\ManagerService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmployeeController extends Controller
{

    /**
     * @var EmployeeService
     */
    private EmployeeService $employeeService;

    public function __construct(EmployeeService $employeeService)
    {
        $this->employeeService = $employeeService;

    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $employees = $this->employeeService->getEmployeesByManagerWithPaginate($request->all());
        return view('website.employees.index', compact('employees'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = $this->employeeService->getCreateEmployeeData();
        return view('website.employees.create')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateEmployeeRequest $request)
    {

        DB::beginTransaction();
        try {
            $this->employeeService->createEmployee($request->validated());
            DB::commit();
        }catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Something went wrong');
        }

        return redirect()->route('employees.index')->with('success', 'Create Employee Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Employee $employee)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Employee $employee)
    {
        try {

            $data = $this->employeeService->getUpdateEmployeeData($employee);
            return view('website.employees.edit')->with($data);
        }catch (\Exception $e){
            abort(403);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEmployeeRequest $request, Employee $employee)
    {
        DB::beginTransaction();
        try {
            $this->employeeService->updateEmployee($request->validated(), $employee);
            DB::commit();
        }catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Something went wrong');
        }

        return redirect()->route('employees.index')->with('success', 'Update Employee Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $employee)
    {
        DB::beginTransaction();
        try {
            $this->employeeService->deleteEmployee($employee);
            DB::commit();
        }catch (\Exception $e){
            DB::rollBack();
            return redirect()->back()->with('error', 'Something went wrong');
        }
        return redirect()->route('employees.index')->with('success', 'Delete Employee Successfully');
    }
}
