<?php

namespace App\Repository;

use App\Entity\Post;
use App\Entity\User;
use App\Entity\UserMute;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Post>
 *
 * @method Post|null find($id, $lockMode = null, $lockVersion = null)
 * @method Post|null findOneBy(array $criteria, array $orderBy = null)
 * @method Post[]    findAll()
 * @method Post[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Post::class);
    }

    public function save(Post $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Post $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function getQuery(string $updatedAtSort, User $user): Query
    {
        return $this
            ->createQueryBuilder('p')
            ->leftJoin(UserMute::class, 'um', 'WITH', 'p.user = um.mute AND um.user = :user AND um.expiredAt > :now')
            ->where('um.id IS NULL')
            ->setParameter('user', $user)
            ->setParameter('now', new \DateTimeImmutable())
            ->orderBy('p.updatedAt', $updatedAtSort)
            ->getQuery();
    }

    public function getPrioritizingQuery(string $updatedAtSort, User $user): Query
    {
        return $this
            ->createQueryBuilder('p')
            ->leftJoin(UserMute::class, 'um', 'WITH', 'p.user = um.mute AND um.user = :user AND um.expiredAt > :now')
            ->where('um.id IS NULL')
            ->setParameter('user', $user)
            ->setParameter('now', new \DateTimeImmutable())
            ->orderBy('p.isPrioritized', 'DESC')
            ->addOrderBy('p.updatedAt', $updatedAtSort)
            ->getQuery();
    }
}
