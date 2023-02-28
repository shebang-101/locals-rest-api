<?php

namespace App\Factory\Post;

interface PostModelFactoryInterface
{
    public function createPostListResult(array $items, $page = null, $limit = null, $total = null);
}