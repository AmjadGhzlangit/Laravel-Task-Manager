<?php

namespace App\Http\API\V1\Repositories\Task;

use App\Filters\SearchPropertiesFilter;
use App\Http\API\V1\Core\PaginatedData;
use App\Http\API\V1\Repositories\BaseRepository;
use App\Models\Task;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;

class TaskRepository extends BaseRepository
{
    public function __construct(Task $model)
    {
        parent::__construct($model);
    }

    public function update(Model $model, $attributes): Model
    {

        $model->update($attributes);

        return $model;
    }

    public function index(): PaginatedData
    {
        $filters = [
            AllowedFilter::exact('id'),
            AllowedFilter::exact('title'),
            AllowedFilter::exact('status'),
            AllowedFilter::custom('search', new SearchPropertiesFilter([
                'title',
                'description',
            ])),
        ];
        $sorts = [
            AllowedSort::field('created_at'),
            AllowedSort::field('updated_at'),
        ];

        return $this->filter(Task::with('user'), $filters, $sorts);
    }

    public function store($data): Model
    {
        $data['user_id'] = Auth::user()->id;

        return parent::store($data);
    }
}
