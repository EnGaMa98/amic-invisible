<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

abstract class BaseService
{
    abstract public function getModel(): Model;

    abstract public function query(array $include = [], array $filter = []): Builder;

    abstract public function get(array $include = [], array $filter = [], array $sort = [], int $perPage = 25);

    protected function sortBy(Builder $query, array $sort): Builder
    {
        $by = $sort['by'] ?? 'id';
        $dir = $sort['dir'] ?? 'desc';

        if ($this->getModel()->getConnection()->getSchemaBuilder()->hasColumn($this->getModel()->getTable(), $by)) {
            $query->orderBy($by, $dir);
        }

        return $query;
    }
}
