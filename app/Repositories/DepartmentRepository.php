<?php

namespace App\Repositories;

use App\Models\Department;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class DepartmentRepository extends BaseRepository
{

    public function __construct(Department $model)
    {
        parent::__construct($model);
    }

    public function getDepartments($conditions = [], $with = [], $filters = []): Model|Builder
    {
        $Departments = $this->all($conditions, $with);
        $this->filterDepartments($Departments, $filters);
        return $Departments;
    }

    protected function filterDepartments(&$Departments, $filters)
    {

        if(isset($filters['search']) && $filters['search'] != ''){
            $Departments->where(function ($Department) use ($filters){
                $Department->where('name', 'like', '%'.$filters['search'].'%');
            });
        }
    }


}
