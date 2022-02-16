<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

class BaseRepository 
{
    public $model;

    public function create(array $details) 
    {
        return $this->model::create($details);
    }

    public function getAll() 
    {
        return $this->model::all();
    }

    public function getById(int $id) 
    {
        return $this->model::findOrFail($id);
    }

    public function updateById(int $id, array $newDetails) 
    {
        $this->model::whereId($id)->update($newDetails);
    }

    public function updateInstance(Model $model, array $newDetails) 
    {
        $model->update($newDetails);
    }

    public function deleteById(int $id) 
    {
        $this->model::destroy($orderId);
    }

    public function deleteInstance(Model $model) 
    {
        $model->delete();
    }
}