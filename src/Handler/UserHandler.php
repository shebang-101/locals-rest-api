<?php

namespace App\Handler;

use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

/**
 * UserModel handler
 */
class UserHandler
{
    private ManagerRegistry $doctrine;
    private UserPasswordHasherInterface $passwordEncoder;

    /**
     * UserModel handler constructor
     *
     * @param ManagerRegistry             $doctrine
     * @param UserPasswordHasherInterface $passwordEncoder
     */
    public function __construct(ManagerRegistry $doctrine, UserPasswordHasherInterface $passwordEncoder) {
        $this->doctrine        = $doctrine;
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * Register user handler.
     * Creates user object with email and password.
     * Stores it to the database.
     *
     * @param \StdClass|null $payload
     *
     * @return void
     */
    public function registerUser(?\StdClass $payload): void
    {
        $em                = $this->doctrine->getManager();
        $email             = $payload->email;
        $plaintextPassword = $payload->password;

        $user           = new User();
        $hashedPassword = $this->passwordEncoder->hashPassword(
            $user,
            $plaintextPassword
        );
        $user->setPassword($hashedPassword);
        $user->setEmail($email);

        $em->persist($user);
        $em->flush();
    }
}