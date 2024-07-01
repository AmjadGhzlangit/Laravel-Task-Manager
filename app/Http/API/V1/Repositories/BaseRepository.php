<?php

namespace App\Http\API\V1\Repositories;

use App\Http\API\V1\Core\PaginatedData;
use Illuminate\Database\Eloquent\Model;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * Class BaseRepository
 *
 * An abstract base class for repositories that provides common database operations.
 */
abstract class BaseRepository
{
    /**
     * @var Model The model instance.
     */
    protected Model $model;

    /**
     * BaseRepository constructor.
     *
     * @param  Model  $model  The model instance.
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Apply filters, sorts, and pagination to a query.
     *
     * @param  mixed  $relation  The relation or model to filter.
     * @param  array  $filters  The allowed filters.
     * @param  array  $sorts  The allowed sorts.
     * @param  array  $defaultSorts  The default sorts.
     * @param  int  $perPage  The number of results per page.
     * @return PaginatedData The paginated data.
     */
    public function filter(mixed $relation, array $filters = [], array $sorts = [], array $defaultSorts = ['-id'], int $perPage = 15): PaginatedData
    {
        $per_page = request('per_page', $perPage);
        $entities = QueryBuilder::for($relation)
            ->defaultSorts($defaultSorts)
            ->allowedFilters($filters)
            ->allowedSorts($sorts);

        return new PaginatedData($entities, $per_page);
    }

    /**
     * Retrieve a paginated list of models.
     *
     * @return PaginatedData The paginated data.
     */
    public function index(): PaginatedData
    {
        return $this->filter($this->model, [], []);
    }

    /**
     * Retrieve a specific model instance.
     *
     * @param  Model  $model  The model instance.
     * @return Model The retrieved model instance.
     */
    public function show(Model $model): Model
    {
        return $model;
    }

    /**
     * Retrieve a model instance by its ID.
     *
     * @param  int  $id  The model ID.
     * @return Model The retrieved model instance.
     */
    public function get($id): Model
    {
        return $this->model::findOrFail($id);
    }

    /**
     * Create a new model instance with the given data.
     *
     * @param  array  $data  The data to create the model with.
     * @return Model The created model instance.
     */
    public function store($data): Model
    {
        return $this->model::create($data);
    }

    /**
     * Update the given model instance with the provided attributes.
     *
     * @param  Model  $model  The model instance to update.
     * @param  array  $attributes  The attributes to update the model with.
     * @return Model The updated model instance.
     */
    public function update(Model $model, $attributes): Model
    {
        $model->fill($attributes);
        $model->save();
        $model->refresh();

        return $model;
    }

    /**
     * Delete the given model instance.
     *
     * @param  Model  $model  The model instance to delete.
     * @return bool|null True if the model was deleted, null otherwise.
     */
    public function delete(Model $model): ?bool
    {
        return $model->delete();
    }

    /**
     * Retrieve a model instance along with specified relationships.
     *
     * @param  Model  $model  The model instance to load relationships for.
     * @param  array|string  $relationships  The relationships to load.
     * @return Model The model instance with loaded relationships.
     */
    public function showWith(Model $model, array|string $relationships): Model
    {
        return $model->load($relationships);
    }
}
