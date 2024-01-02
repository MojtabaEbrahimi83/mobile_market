<?php

namespace App\Repositories;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Spatie\QueryBuilder\QueryBuilder;

class BaseRepository implements BaseRepositoryInterface
{

    public function __construct(public Model $model)
    {
    }


    public function query(array $payload = []): Builder|QueryBuilder
    {
        return $this->model->query();
    }

    public function paginate($limit = null, array $payload = []): LengthAwarePaginator|Collection
    {
        if (empty($limit)) {
            $limit = request('limit', '15');
        }
        if ($limit === -1) {
            return $this->get($payload);
        }
        return $this->query($payload)->paginate($limit);
    }

    public function get(array $payload = []): Collection
    {
        return $this->query($payload)->get();
    }

    public function store(array $payload = [])
    {
        return $this->model->create($payload);
    }

    public function update($eloquent, array $payload = [])
    {
        $eloquent->update($payload);
        return $eloquent;
    }

    public function delete($eloquent)
    {
        return $eloquent->delete();
    }

    public function find(mixed $value, string $field = 'id', array $selected = ['*'], bool $firstOrFail = false, array $with = [])
    {
        $model = $this->getModel()->with($with)->select($selected)->where($field, $value);
        if ($firstOrFail){
            return $model->firstOrFail();
        }
        return $model->first();
    }

    public function getModel(): Model
    {
        return $this->model;
    }

    public function toggle($model, $filed = 'published')
    {
        $model[$filed] = !$model[$filed];
        $model->save();
        return $model;
    }

    public function updateOrCreate($data, array $conditions = [])
    {
        $this->model->updateOrCreate($conditions, $data);
    }

    public function data(array $date)
    {
        return [];
    }
}
