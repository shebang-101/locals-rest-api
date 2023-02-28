<?php

namespace App\DataFixtures;

use App\Entity\Post;
use App\Entity\User;
use App\Entity\UserMute;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordEncoder;

    /**
     * App fixtures constructor
     *
     * @param UserPasswordHasherInterface $passwordEncoder
     */
    public function __construct(UserPasswordHasherInterface $passwordEncoder) {

        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 30; $i++) {
            $user           = new User();
            $hashedPassword = $this->passwordEncoder->hashPassword(
                $user,
                "SomeSeCUrePassword"
            );
            $user->setPassword($hashedPassword);
            $user->setEmail("test$i@test.com");

            $manager->persist($user);

            for ($j = 0; $j < 30; $j++) {
                $post = (new Post())
                    ->setTitle("$j. What is Lorem Ipsum?")
                    ->setBody("$j. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.")
                    ->setUser($user);

                $manager->persist($post);
                $this->setReference("post_$j", $post);
            }

            $this->addReference("user_$i", $user);
        }

        /** @var User $user */
        $user = $this->getReference('user_0');
        $user->addMute((new UserMute())
            ->setUser($user)
            ->setMute($this->getReference('user_1'))
            ->setExpiredAt((new \DateTimeImmutable())->modify("+1 months"))
        );

        $manager->persist($user);

        for ($i = 0; $i < 3; $i++) {
            /** @var Post $post */
            $post = $this->getReference("post_$i");
            $post->setIsPrioritized(true);

            $manager->persist($post);
        }

        $manager->flush();
    }
}
