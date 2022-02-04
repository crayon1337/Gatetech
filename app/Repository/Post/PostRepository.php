<?php

namespace App\Repository\Post;

use App\Models\Post;
use App\Repository\Eloquent\BaseRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Str;

class PostRepository extends BaseRepository implements PostInterface
{
    /**
     * PostRepository constructor.
     * @param Post $model
     */
    public function __construct(Post $model)
     {
         parent::__construct($model);
     }

    /**
     * @param string $slug
     * @return mixed|void
     */
    public function findBySlug(string $slug)
    {
        return $this->model::whereSlug($slug)
            ->with('user')
            ->whereIsavailable(true)
            ->firstOrFail();
    }

    /**
     * @param string $name
     * @return mixed
     */
    public function isSlugExists(string $name)
    {
        return $this->model::whereSlug(Str::slug($name))->exists();
    }
}
