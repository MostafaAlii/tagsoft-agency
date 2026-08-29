<?php

namespace Core\Repositories;

use Core\Contracts\BaseRepositoryInterface;
use Core\Traits\Cacheable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

abstract class BaseRepository implements BaseRepositoryInterface
{
    use Cacheable;

    protected Model $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function all(array $columns = ['*'], array $relations = []): Collection
    {
        return $this->model->with($relations)->get($columns);
    }

    public function paginate(int $perPage = 15, array $columns = ['*'], array $relations = []): LengthAwarePaginator
    {
        return $this->model->with($relations)->paginate($perPage, $columns);
    }

    public function findById(string $id, array $columns = ['*'], array $relations = []): ?Model
    {
        return $this->rememberCache($this->getCacheKey("find_{$id}"), fn() => $this->model->with($relations)->find($id, $columns));
    }

    public function create(array $payload): Model
    {
        $model = $this->model->create($payload);
        $this->forgetCache($this->getCacheKey("find_{$model->getKey()}"));
        return $model;
    }

    public function update(string $id, array $payload): bool
    {
        $model = $this->model->find($id);
        if (!$model) return false;

        $updated = $model->update($payload);
        if ($updated) {
            $this->forgetCache($this->getCacheKey("find_{$id}"));
        }
        return $updated;
    }

    public function delete(string $id): bool
    {
        $model = $this->model->find($id);
        if (!$model) return false;

        $deleted = (bool) $model->delete();
        if ($deleted) {
            $this->forgetCache($this->getCacheKey("find_{$id}"));
        }
        return $deleted;
    }
}
