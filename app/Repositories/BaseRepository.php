<?php

namespace App\Repositories;

use App\Contracts\BaseContract;
use App\Exceptions\WebException;
use Exception;
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
        try {
            return $this->model->find($id)->update($attributes);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function all($columns = array("*"), string $orderBy = "id", string $sortBy = "asc"): mixed
    {
        try {
            return $this->model->orderBy($orderBy, $sortBy)->get($columns);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function find(int $id): mixed
    {
        try {
            return $this->model->find($id);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function findOneOrFail(int $id): mixed
    {
        try {
            return $this->model->findOrFail($id);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function findBy(array $data): mixed
    {
        try {
            return $this->model->where($data)->all();
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function findOneBy(array $data): mixed
    {
        try {
            return $this->model->where($data)->first();
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function findOneByOrFail(array $data): mixed
    {
        try {
            return $this->model->where($data)->firstOrFail();
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function delete(int $id): mixed
    {
        try {
            return $this->model->find($id)->delete();
        } catch (Exception $e) {
            throw $e;
        }
    }
}
