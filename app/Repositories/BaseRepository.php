<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

abstract class BaseRepository
{

    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function all($conditions = [], $with = [])
    {
        $query = $this->model;
        $query = $conditions != [] ? $query->where($conditions) : $query;
        $query = $with != [] ? $query->with($with) : $query;
        return $query;//->get();
    }

    public function paginate($query, $per_page = 15, $conditions = [], $sort_key = 'id', $sort_order = 'asc', $has_relations = null)
    {
        $query = $conditions != [] ? $query->where($conditions) : $query;
        // sort by specific key in ascending or descending
        $query = $sort_key != null ? $query->orderBy($sort_key, $sort_order) : $query;

        $query = $has_relations ? $this->has($query, $has_relations) : $query;

        return $query->paginate($per_page);
    }

    public function create(array $attributes, $load = [])
    {
        $data = $this->model->create($attributes);

        return $load != []
            ? $data->load($load)
            : $data;
    }

    public function updateOrCreate(array $required_attributes, array $optional_attributes = [], $load = [])
    {
        $data = $this->model->updateOrCreate($required_attributes, $optional_attributes);

        return $load != []
            ? $data->load($load)
            : $data;
    }

    public function get($value, $conditions = [], $column = 'id', $with = [])
    {
        $data = $conditions != []
            ? $this->model->where($conditions)
            : $this->model;

        $data = $with != []
            ? $data->with($with)
            : $data;

        $data = $column
            ? $data->where($column, $value)
            : $data;

        $data = $data->firstOrFail();

        return $data;
    }

    public function update($value, $attributes = [], $conditions = [], $column = 'id', $with = [])
    {
        $lang = Session::get('locale');

        Session::put('locale','all');

        $data = $this->getModel($value, $conditions, $column);

        $data->update($attributes);

        Session::put('locale', $lang);

        $data = $this->getModel($value, $conditions, $column);

        return $data->load($with);
    }

    private function getModel($value, $conditions, $column){
        $data = $conditions != []
            ? $this->model->where($conditions)
            : $this->model;

        $data = $column
            ? $data->where($column, $value)
            : $data;
        return $data->firstOrFail();
    }

    public function delete($value, $conditions = [], $column = 'id')
    {
        $data = $conditions != []
            ? $this->model->where($conditions)
            : $this->model;
        $data = $column
            ? $data->where($column, $value)
            : $data;
        $data = $data->firstOrFail();

        return $data->delete();
    }

    public function activeList($has_active = false, $conditions = [], $with = [] ,$limit = 10){
        $query = $this->model;
        $query = $conditions != [] ? $query->where($conditions) : $query;
        $query = $has_active ? $query->where('is_active', 1) : $query;
        $query = $with != [] ? $query->with($with) : $query;
        $query = $query->take($limit);
        return $query->get();
    }


    public function count($conditions = [])
    {
        $query = $this->model;
        $query = $conditions != [] ? $query->where($conditions) : $query;
        return $query->count();
    }

    public function has($query , $conditions = [])
    {
        return $query->whereHas($conditions);
    }

    public function getModelPath()
    {
        return get_class($this->model);
    }

    public function getDataBySlug($slug,$conditions = [])
    {
        return $this->model->where(function($query)use($slug){
            $query->where('slug->en',$slug)
                ->orWhere('slug->ar',$slug);
        })->where($conditions)->firstOrFail();
    }
}
