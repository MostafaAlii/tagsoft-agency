<?php
declare(strict_types=1);
namespace Core\Repositories;
use Core\Contracts\BaseRepositoryInterface;
use Core\Traits\Cacheable;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\{Collection, Model};
use Illuminate\Support\Facades\DB;

abstract class BaseRepository implements BaseRepositoryInterface {
    use Cacheable;
    protected Model $model;
    public function __construct(Model $model) {
        $this->model = $model;
    }

    public function all(array $columns = ['*'], array $relations = []): Collection {
        return $this->model->with($relations)->get($columns);
    }

    public function paginate(int $perPage = 15, array $columns = ['*'], array $relations = []): LengthAwarePaginator {
        return $this->model->with($relations)->paginate($perPage, $columns);
    }

    public function findById(string $id, array $columns = ['*'], array $relations = []): ?Model {
        return $this->rememberCache(
            $this->getCacheKey("find_{$id}"),
            fn() => $this->model->with($relations)->where('uuid', $id)->first($columns)
        );
    }

    public function create(array $payload): Model {
        return DB::transaction(function () use ($payload) {
            return $this->model->create($payload);
        });
    }

    public function update(string $id, array $payload): bool {
        $model = $this->model->where('uuid', $id)->first();
        if (!$model) {
            return false;
        }
        $updated = $model->update($payload);
        if ($updated) {
            $this->forgetCache($this->getCacheKey("find_{$id}"));
        }
        return $updated;
    }

    public function delete(string $id): bool {
        $model = $this->model->where('uuid', $id)->first();
        if (!$model) {
            return false;
        }
        $deleted = (bool) $model->delete();
        if ($deleted) {
            $this->forgetCache($this->getCacheKey("find_{$id}"));
        }
        return $deleted;
    }
}
