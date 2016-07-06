<?php
/**
 * Description: 逻辑调用层的根类
 * Created by PhpStorm.
 * User: Lihong
 * Date: 15-12-19
 * Time: 上午11:23
 */

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

abstract class Repository
{
    /**
     * @var \Illuminate\Database\Eloquent\Model
     */
    protected $model;

    public function __construct($model = null)
    {
        $this->model = $model;
    }

    public function getModel()
    {
        return $this->model;
    }

    public function setModel($model)
    {
        $this->model = $model;
    }

    public function getAll()
    {
        return $this->model->all();
    }


    public function getById($id)
    {
        return $this->model->find($id);
    }

    public function requireById($id)
    {
        $model = $this->findOrFail($id);

        return $model;
    }

    public function getNew($attributes = array())
    {
        return $this->model->newInstance($attributes);
    }

    public function getAllPaginated($count)
    {
        return $this->model->paginate($count);
    }

    public function findOrFail($id)
    {
        return $this->model->findOrFail($id);
    }

    public function create($data)
    {
        return $this->model->create($data);
    }

    public function save($data)
    {
        if ($data instanceOf Model) {
            return $this->storeEloquentModel($data);
        } elseif (is_array($data)) {
            return $this->storeArray($data);
        }
    }

    protected function storeEloquentModel($model)
    {
        if ($model->getDirty()) {
            return $model->save();
        } else {
            return $model->touch();
        }
    }

    protected function storeArray($data)
    {
        $model = $this->getNew($data);
        return $this->storeEloquentModel($model);
    }


    public function delete($model)
    {
        return $model->delete();
    }

    public function destroy($id)
    {
        return $this->model->destroy($id);
    }
}