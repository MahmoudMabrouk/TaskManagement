<?php

namespace App\Repositories;

use App\Models\Task;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class TaskRepository extends BaseRepository
{

    public function __construct(Task $model)
    {
        parent::__construct($model);
    }

    public function getTasks($conditions = [], $with = [], $filters = []): Model|Builder
    {
        $Tasks = $this->all($conditions, $with);
        $this->filterTasks($Tasks, $filters);
        return $Tasks;
    }

    protected function filterTasks(&$Tasks, $filters)
    {

        if(isset($filters['search']) && $filters['search'] != ''){
            $Tasks->where(function ($Task) use ($filters){
                $Task->where('title', 'like', '%'.$filters['search'].'%')
                ->orWhere('description', 'like', '%'.$filters['search'].'%')
                ->orWhere('status', 'like', '%'.$filters['search'].'%');
            })->orWhereHas('employee', function ($q) use ($filters) {
                $q->whereHas('user', function ($q) use ($filters) {
                    $q->where('first_name', 'like', '%'.$filters['search'].'%')
                        ->orWhere('last_name', 'like', '%'.$filters['search'].'%');
                });
            })->orWhereHas('manager', function ($q) use ($filters) {
                $q->whereHas('user', function ($q) use ($filters) {
                    $q->where('first_name', 'like', '%'.$filters['search'].'%')
                        ->orWhere('last_name', 'like', '%'.$filters['search'].'%');
                })->orWhere('title', 'like',  '%'.$filters['search'].'%');
            });
        }
    }


}
