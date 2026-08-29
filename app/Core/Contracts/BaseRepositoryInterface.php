<?php

namespace Core\Contracts;

use Illuminate\Database\Eloquent\{Collection,Model};
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface BaseRepositoryInterface
{
    public function all(array $columns = ['*'], array $relations = []): Collection;

    public function paginate(int $perPage = 15, array $columns = ['*'], array $relations = []): LengthAwarePaginator;

    public function findById(string $id, array $columns = ['*'], array $relations = []): ?Model;

    public function create(array $payload): Model;

    public function update(string $id, array $payload): bool;

    public function delete(string $id): bool;
}