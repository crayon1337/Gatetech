<?php

namespace App\Repository\Eloquent;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;

interface EloquentRepositoryInterface
{
    /**
     * @param int $maxResults
     * @param string $statusColumn
     * @return LengthAwarePaginator|null
     */
    public function all(int $maxResults, string $statusColumn): ?LengthAwarePaginator;

    /**
     * @param $id
     * @return Model
     */
    public function findOrFail($id): ?Model;

    /**
     * @param array $attributes
     * @return Model
     */
    public function create(array $attributes): Model;

}
