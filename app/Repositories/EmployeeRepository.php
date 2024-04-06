<?php

namespace App\Repositories;

use App\Models\Employee;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class EmployeeRepository extends BaseRepository
{

    public function __construct(Employee $model)
    {
        parent::__construct($model);
    }

    public function getEmployees($conditions = [], $with = [], $filters = []): Model|Builder
    {
        $employees = $this->all($conditions, $with);
        $this->filterEmployees($employees, $filters);
        return $employees;
    }

    protected function filterEmployees(&$employees, $filters)
    {

        if(isset($filters['search']) && $filters['search'] != ''){
            $employees->where(function ($employee) use ($filters){
                $employee->where('salary', 'like', '%'.$filters['search'].'%')
                    ->orWhereHas('user', function ($q) use ($filters) {
                        $q->where('first_name', 'like', '%'.$filters['search'].'%')
                            ->orWhere('last_name', 'like', '%'.$filters['search'].'%')
                            ->orWhere('email', 'like', '%'.$filters['search'].'%');
                    })->orWhereHas('department', function ($q) use ($filters) {
                        $q->where('name', 'like', '%'.$filters['search'].'%');
                    })->orWhereHas('manager', function ($q) use ($filters) {
                        $q->whereHas('user', function ($q) use ($filters) {
                            $q->where('first_name', 'like', '%'.$filters['search'].'%')
                                ->orWhere('last_name', 'like', '%'.$filters['search'].'%');
                        })->orWhere('title', 'like',  '%'.$filters['search'].'%');;
                    });
            });
        }
    }


}
