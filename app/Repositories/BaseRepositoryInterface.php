<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\QueryBuilder;

interface BaseRepositoryInterface
{

    public function query(array $payload = []): Builder|QueryBuilder;

    public function paginate($limit = 15, array $payload = []): LengthAwarePaginator|Collection;

    public function get(array $payload = []): Collection;

    public function store(array $payload = []);

    public function update($eloquent, array $payload = []);

    public function delete($eloquent);

    public function find(mixed $value, string $field = 'id', array $selected = ['*'], bool $firstOrFail = false, array $with = []);

    public function getModel(): Model;

    public function toggle($model, $filed = 'published');

    public function updateOrCreate($data, array $conditions = []);

    public function data(array $date);

}
