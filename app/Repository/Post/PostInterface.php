<?php

namespace App\Repository\Post;

// I know I could've added this to the base interface in such a project as long as I use that here and in CategoryInterface. But I just wanted to demonstrate how I use
// Repository design pattern in large-scale websites

interface PostInterface
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
