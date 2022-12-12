<?php

namespace App\Repositories;

use App\Contracts\BaseContract;
use App\Exceptions\NotFoundException;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class BaseRepository implements BaseContract
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function create(array $attributes): mixed
    {
        return $this->model->create($attributes);
    }

    public function update(array $attributes, int $id): mixed
    {
        return $this->model->findOrFail($id)->update($attributes);
    }

    public function all($columns = array("*"), string $orderBy = "id", string $sortBy = "asc"): mixed
    {
        return $this->model->orderBy($orderBy, $sortBy)->get($columns);
    }

    public function findOneOrFail(int $id): mixed
    {
        return $this->model->findOrFail($id);
    }

    public function findBy(array $data): mixed
    {
        return $this->model->where($data)->get();
    }

    public function findOneByOrFail(array $data): mixed
    {
        return $this->model->where($data)->firstOrFail();
    }

    public function delete(int $id): mixed
    {
        return $this->model->findOrFail($id)->delete();
    }
}
