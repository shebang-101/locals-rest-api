<?php

namespace App\Model\Post;

/**
 * Post model result.
 * Used in factory for serializing the results.
 */
class PostListModelResult
{

    public int $page;
    public int $limit;
    public int $total;
    public array $posts;
}
