<?php

namespace App\Repository\Category;

use App\Models\Category;
use App\Repository\Eloquent\BaseRepository;
use Illuminate\Support\Str;

class CategoryRepository extends BaseRepository implements CategoryInterface
{
    /**
     * CategoryRepository constructor.
     * @param Category $model
     */
    public function __construct(Category $model)
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
