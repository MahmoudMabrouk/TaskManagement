<?php

namespace App\Services;

use App\Repositories\TaskRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

class TaskService
{

    const COUNT = 20;
    const STATUSES = [
        'to_do'         => 'To Do',
        'in_progress'   => 'In Progress',
        'testing'       => 'Testing',
        'done'          => 'Done'
    ];
    protected TaskRepository $taskRepository;

    public function __construct(TaskRepository $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    public function getAllTasks($filters = []): Collection
    {
        return $this->taskRepository->getTasks([], [], $filters)
            ->get();
    }

    public function getStatuses(): array
    {
        return self::STATUSES;
    }

    public function getTasks($filters = []): LengthAwarePaginator
    {
        if (auth()->user()->role == 'manager'){
            $conditions['manager_id'] = optional(auth()->user()->manager)->id;
        }else{
            $conditions['employee_id'] = optional(auth()->user()->employee)->id;
        }

        return $this->taskRepository->getTasks($conditions, [], $filters)
            ->paginate(self::COUNT);
    }

    public function createTask($request)
    {
        $request['manager_id'] = optional(auth()->user()->manager)->id;
        $this->taskRepository->create($request);
    }

    /**
     * @throws \Exception
     */
    public function updateTaskStatus($request, $task)
    {
        if (!($task instanceof Model)){
            $task = $this->taskRepository->get($task);
        }

        if ($task->employee_id != optional(auth()->user()->employee)->id){
            throw new \Exception(' Permission denied!');
        }

        $this->taskRepository->update($task->id, $request);
    }
}
