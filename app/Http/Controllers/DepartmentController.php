<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateDepartmentRequest;
use App\Http\Requests\UpdateDepartmentRequest;
use App\Models\Department;
use App\Services\DepartmentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DepartmentController extends Controller
{

    /**
     * @var DepartmentService
     */
    private DepartmentService $departmentService;

    public function __construct(DepartmentService $departmentService)
    {
        $this->departmentService = $departmentService;

    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $departments = $this->departmentService->getDepartments($request->all());
        return view('website.departments.index', compact('departments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('website.departments.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateDepartmentRequest $request)
    {
        DB::beginTransaction();
        try {
            $this->departmentService->createDepartment($request->all());
            DB::commit();
        }catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Something went wrong');
        }

        return redirect()->route('departments.index')->with('success', 'Create Department Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Department $department)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Department $department)
    {

        $data = $this->departmentService->getUpdateDepartmentData($department);
        return view('website.departments.edit')->with($data);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDepartmentRequest $request, Department $department)
    {
        DB::beginTransaction();
        try {
            $this->departmentService->updateDepartment($request->validated(), $department);
            DB::commit();
        }catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Something went wrong');
        }

        return redirect()->route('departments.index')->with('success', 'Update Department Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Department $department): \Illuminate\Http\RedirectResponse
    {
        try {
            $this->departmentService->deleteDepartment($department);
        }catch (\Exception $e){
            return redirect()->back()->with('error', 'Something went wrong');
        }
        return redirect()->route('departments.index')->with('success', 'Delete Department Successfully');
    }
}
