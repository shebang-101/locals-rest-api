<?php

namespace App\Factory\Post;

use App\Entity\Post;
use App\Model\Post\PostModel;
use App\Model\Post\PostListModelResult;
use App\Model\User\UserModel;

class PostFactory implements PostModelFactoryInterface
{
    public function createPostListResult(array $posts, $page = null, $limit = null, $total = null): PostListModelResult
    {
        $result        = new PostListModelResult();
        $result->page  = $page;
        $result->limit = $limit;
        $result->posts = [];
        $result->total = $total;

        foreach ($posts as $item) {
            $result->posts[] = $this->createPost($item);
        }

        return $result;
    }

    public function createPost(Post $post): PostModel
    {
        $user        = new UserModel();
        $user->id    = $post->getUser()->getId();
        $user->email = $post->getUser()->getEmail();

        $model            = new PostModel();
        $model->id        = $post->getId();
        $model->title     = $post->getTitle();
        $model->body      = $post->getBody();
        $model->user      = $user;
        $model->createdAt = $post->getCreatedAt()->getTimestamp();
        $model->updatedAt = $post->getUpdatedAt()->getTimestamp();

        return $model;
    }
}