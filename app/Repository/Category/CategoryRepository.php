<?php

namespace App\Repository\Category;

use App\Models\Category;
use App\Repository\Eloquent\BaseRepository;

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
}
