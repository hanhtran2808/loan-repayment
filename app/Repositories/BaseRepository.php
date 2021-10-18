<?php


namespace App\Repositories;


use App\Repositories\Interfaces\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class BaseRepository implements BaseRepositoryInterface
{
    /**
     * The Model name.
     *
     * @var Model;
     */
    protected $model;

    /**
     * Create a new model and return the instance.
     *
     * @param array $inputs
     *
     * @return Model instance
     */
    public function store(array $inputs)
    {
        return $this->model->create($inputs);
    }

    /**
     * Update the model in the database.
     *
     * @param $id
     * @param array $inputs
     * @return bool
     */
    public function update($id, array $inputs)
    {
        $model = $this->findById($id);
        return $model->update($inputs);
    }

    /**
     * FindOrFail Model and return the instance.
     *
     * @param $id
     *
     * @return Model|Collection
     */
    public function findById($id)
    {
        $model = $this->model->find($id);
        return isset($model) ? $model : null;
    }
}