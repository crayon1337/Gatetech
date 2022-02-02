<?php

namespace App\Repository\Eloquent;

use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;

class BaseRepository implements EloquentRepositoryInterface
{
    /**
     * @var Model
     */
    protected $model;

    /**
     * BaseRepository constructor.
     *
     * @param Model $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * @param array $attributes
     *
     * @return Model
     */
    public function create(array $attributes): Model
    {
        return $this->model->create($attributes);
    }

    /**
     * @param $id
     * @return Model
     */
    public function findOrFail($id): ?Model
    {
        return $this->model->findOrFail($id);
    }

    /**
     * @param int $maxResults
     * @param string $statusColumn
     * @return LengthAwarePaginator|null
     * @throws Exception
     */
    public function all(int $maxResults, string $statusColumn): ?LengthAwarePaginator
    {
        try {
            $data = $this->model;

            if(isset($statusColumn))
                $data->where($statusColumn, true);

            return $data->paginate($maxResults);

        } catch(Exception $e) {
            $message = $e->getMessage();
            throw new Exception('Could not fetch the database. \n Reason:' . $message, 500);
        }
    }
}
