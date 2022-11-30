<?php

namespace App\Repositories;

use App\Contracts\BaseContract;
use App\Exceptions\WebException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Database\QueryException;

class BaseRepository implements BaseContract
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function create(array $attributes): mixed
    {
        try {
            return $this->model->create($attributes);
        } catch (QueryException $e) {
            throw $e;
        }
    }

    public function update(array $attributes, int $id): mixed
    {
        return $this->model->find($id)->update($attributes);
    }

    public function all($columns = array("*"), string $orderBy = "id", string $sortBy = "asc"): mixed
    {
        return $this->model->orderBy($orderBy, $sortBy)->get($columns);
    }

    public function find(int $id): mixed
    {
        return $this->model->find($id);
    }

    public function findOneOrFail(int $id): mixed
    {
        return $this->model->findOrFail($id);
    }

    public function findBy(array $data): mixed
    {
        return $this->model->where($data)->all();
    }

    public function findOneBy(array $data): mixed
    {
        return $this->model->where($data)->first();
    }

    public function findOneByOrFail(array $data): mixed
    {
        return $this->model->where($data)->firstOrFail();
    }

    public function delete(int $id): mixed
    {
        return $this->model->find($id)->delete();
    }
}
