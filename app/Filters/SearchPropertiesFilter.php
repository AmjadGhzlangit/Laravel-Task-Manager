<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Spatie\QueryBuilder\Filters\Filter;

class SearchPropertiesFilter implements Filter
{
    protected array $properties;

    public function __construct(array $properties)
    {
        $this->properties = $properties;
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function __invoke(Builder $query, $value, string $property): void
    {
        $firstProperty = array_shift($this->properties);
        $query->where(function (Builder $query) use ($firstProperty, $value) {
            $query->where($firstProperty, 'like', "%{$value}%");
            foreach ($this->properties as $property) {
                $query->orWhere($property, 'like', "%{$value}%");
            }
        });
        $filters = request()->get('filter');
        foreach ($filters as $key => $filterVal) {
            if ($this->isColumnExists($query, $key)) {
                $query->where($key, '=', $filterVal);
            }
        }
    }

    /**
     * Check if a column exists in the given query's table.
     */
    protected function isColumnExists(Builder $query, string $column): bool
    {
        $columns = $query->getModel()->getFillable();

        return in_array($column, $columns);
    }
}
