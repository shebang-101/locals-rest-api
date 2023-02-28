<?php

namespace App\Handler;

use App\Entity\Post;
use App\Entity\User;
use App\Factory\Post\PostFactory;
use App\Model\Post\PostListModelResult;
use App\Model\Post\PostModel;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Security\Core\Security;

/**
 * UserModel handler
 */
class PostHandler
{
    private ManagerRegistry $doctrine;
    private PaginatorInterface $paginator;
    private PostFactory $postFactory;
    private ?User $user;

    /**
     * @param ManagerRegistry    $doctrine
     * @param PaginatorInterface $paginator
     * @param PostFactory    $postFactory
     * @param Security           $security
     */
    public function __construct(
        ManagerRegistry    $doctrine,
        PaginatorInterface $paginator,
        PostFactory        $postFactory,
        Security           $security
    ) {
        $this->doctrine    = $doctrine;
        $this->paginator   = $paginator;
        $this->postFactory = $postFactory;
        $this->user        = $security->getUser();
    }

    public function all(string $sort, int $page, int $limit): PostListModelResult
    {
        $updatedAtSort = $sort === 'recent' ? 'DESC' : ($sort === 'oldest' ? 'ASC' : 'DESC');
        $queryResult   = $this->doctrine->getRepository(Post::class)->getQuery($updatedAtSort, $this->user);
        $pagination    = $this->paginator->paginate($queryResult, $page, $limit);

        return $this->createPostListResult(
                $pagination->getItems(),
                $page,
                $limit,
                $pagination->getTotalItemCount()
            );
    }

    public function allPrioritizing(string $sort, int $page, int $limit): PostListModelResult
    {
        $updatedAtSort = $sort === 'recent' ? 'DESC' : ($sort === 'oldest' ? 'ASC' : 'DESC');
        $queryResult   = $this->doctrine->getRepository(Post::class)->getPrioritizingQuery($updatedAtSort, $this->user);
        $pagination    = $this->paginator->paginate($queryResult, $page, $limit);

        return $this->createPostListResult(
            $pagination->getItems(),
            $page,
            $limit,
            $pagination->getTotalItemCount()
        );
    }

    public function getOnePost(Post $post): PostModel
    {
        return $this->postFactory->createPost($post);
    }

    private function createPostListResult($posts, $page = null, $limit = null, $total = null): PostListModelResult
    {
        return $this->postFactory->createPostListResult($posts, $page, $limit, $total);
    }
}