<?php

namespace App\Repository\Category;

interface CategoryInterface
{
    /**
     * @param $slug
     * @return mixed
     */
    public function findBySlug(string $slug);

    /**
     * @param string $name
     * @return mixed
     */
    public function isSlugExists(string $name);
}
