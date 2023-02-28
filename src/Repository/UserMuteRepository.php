<?php

namespace App\Repository;

use App\Entity\UserMute;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<UserMute>
 *
 * @method UserMute|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserMute|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserMute[]    findAll()
 * @method UserMute[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserMuteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserMute::class);
    }

    public function save(UserMute $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(UserMute $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
