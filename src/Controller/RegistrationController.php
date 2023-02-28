<?php

namespace App\Controller;

use App\Handler\UserHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api', name: 'api_')]
class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'register', methods: ['POST'])]
    public function index(UserHandler $handler, Request $request): JsonResponse
    {
        try {
            $handler->registerUser(json_decode($request->getContent()));

            return $this->json([
                'message' => 'Registered Successfully!',
                'error'   => false,
            ]);
        } catch (\Exception $e) {
            return $this->json([
                'message' => $e->getMessage(),
                'error'   => true,
            ], 500);
        }
    }
}
