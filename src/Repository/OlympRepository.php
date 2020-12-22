<?php

namespace App\Repository;

use App\Entity\Olymp;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Olymp|null find($id, $lockMode = null, $lockVersion = null)
 * @method Olymp|null findOneBy(array $criteria, array $orderBy = null)
 * @method Olymp[]    findAll()
 * @method Olymp[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OlympRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Olymp::class);
    }

    /**
     * @return Olymp[]
     */
    public function getWithAll(): array
    {
        return $this->createQueryBuilder('o')
            ->select('o,t,l')
            ->leftJoin('o.tours', 't')
            ->leftJoin('o.languages', 'l')
            ->orderBy('o.id', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function getWithPublishedTours()
    {
        $result =  $this->createQueryBuilder('o')
            ->select('o,t,l')
            ->leftJoin('o.tours', 't')
            ->leftJoin('o.languages','l')
            ->where('t.publishedAt is NOT NULL')
            ->orderBy('t.startedAt', 'DESC')
            ->getQuery()
            ->getResult();

        return $result;
    }
}
