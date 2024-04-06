<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTaskRequest;
use App\Http\Requests\TaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Task;
use App\Services\DepartmentService;
use App\Services\EmployeeService;
use App\Services\TaskService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TaskController extends Controller
{
    /**
     * @var TaskService
     */
    private TaskService $taskService;
    private EmployeeService $employeeService;

    public function __construct(TaskService $taskService,
                                EmployeeService $employeeService)
    {
        $this->taskService = $taskService;
        $this->employeeService = $employeeService;

    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $tasks = $this->taskService->getTasks($request->all());
        $statuses = $this->taskService->getStatuses();
        return view('website.tasks.index', compact('tasks', 'statuses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $employees = $this->employeeService->getEmployeesByManager();
        $statuses = $this->taskService->getStatuses();
        return view('website.tasks.create', compact('employees', 'statuses'));
    }

    public function store(CreateTaskRequest $request)
    {
        DB::beginTransaction();
        try {
            $this->taskService->createTask($request->validated());
            DB::commit();
        }catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Something went wrong');
        }

        return redirect()->route('tasks.index')->with('success', 'Create Task Successfully');
    }

    public function updateStatus(UpdateTaskRequest $request, Task $task): RedirectResponse
    {

        DB::beginTransaction();
        try {
            $this->taskService->updateTaskStatus($request->validated(),$task);
            DB::commit();
        }catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Something went wrong');
        }

        return redirect()->route('tasks.index')->with('success', 'update Task Status Successfully');
    }
}
