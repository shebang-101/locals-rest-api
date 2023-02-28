<?php

namespace App\Controller;

use App\Entity\Post;
use App\Handler\PostHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api', name: 'api_')]
class PostController extends AbstractController
{
    #[Route('/posts', name: "post_all", methods: ["GET"])]
    public function all(PostHandler $postHandler, Request $request): JsonResponse
    {
        try {
            $paginated = $postHandler->all(
                $request->query->get('sort', 'recent'),
                $request->query->getInt('page', 1),
                $request->query->getInt('limit', 20)
            );

            return $this->json($paginated);
        } catch (\Exception $e) {
            return $this->json([
                'message' => $e->getMessage(),
                'error'   => true,
            ], 500);
        }
    }

    #[Route('/prioritizing-posts', name: "post_prioritizing_all", methods: ["GET"])]
    public function allPrioritizing(PostHandler $postHandler, Request $request): JsonResponse
    {
        try {
            $paginated = $postHandler->allPrioritizing(
                $request->query->get('sort', 'recent'),
                $request->query->getInt('page', 1),
                $request->query->getInt('limit', 20)
            );

            return $this->json($paginated);
        } catch (\Exception $e) {
            return $this->json([
                'message' => $e->getMessage(),
                'error'   => true,
            ], 500);
        }
    }

    #[Route('/posts/{id}', name: "post_show", methods: ["GET"])]
    public function show(Post $post, PostHandler $postHandler,): JsonResponse
    {
        try {
            return $this->json($postHandler->getOnePost($post));
        } catch (\Exception $e) {
            return $this->json([
                'message' => $e->getMessage(),
                'error'   => true,
            ], 500);
        }
    }

    #[Route('/posts', name: "post_create", methods: ["POST"])]
    public function create(Request $request): JsonResponse
    {
        return $this->json([
            'message' => 'Not implemented!',
            'error'   => true,
        ]);
    }

    #[Route('/posts/{id}', name: "post_edit", methods: ["PUT"])]
    public function edit(Post $id, Request $request): JsonResponse
    {
        return $this->json([
            'message' => 'Not implemented!',
            'error'   => true,
        ]);
    }

    #[Route('/posts/{id}', name: "post_delete", methods: ["DELETE"])]
    public function delete($id): JsonResponse
    {
        return $this->json([
            'message' => 'Not implemented!',
            'error'   => true,
        ]);
    }
}
