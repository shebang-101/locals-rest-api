<?php

namespace App\Model\Post;

use App\Model\User\UserModel;

/**
 * Post model.
 * Used in Post factory for serializing the results for single Post.
 */
class PostModel
{
    public int $id;
    public string $title;
    public string $body;
    public UserModel $user;
    public int $createdAt;
    public int $updatedAt;
}