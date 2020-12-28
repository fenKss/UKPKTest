<?php

namespace App\Repository;

use App\Entity\Olymp;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\User\UserInterface;

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
            ->getQuery()
            ->getResult();
    }

    /**
     * @return mixed
     */
    public function getWithPublishedTours()
    {
        return $this->getWithPublishedToursQuery()->getResult();
    }

    /**
     * @return Query
     */
    public function getWithPublishedToursQuery(): Query
    {
        return $this->createQueryBuilder('o')
            ->select('o,t,l')
            ->leftJoin('o.tours', 't')
            ->leftJoin('o.languages', 'l')
            ->where('t.publishedAt is NOT NULL')
            ->orderBy('t.startedAt', 'DESC')
            ->getQuery();
    }

    /**
     * @param UserInterface|null $user
     *
     * @return int|mixed|string
     */
    public function getByUser(?UserInterface $user)
    {
        return $this->createQueryBuilder('o')
            ->select('o,t,l')
            ->leftJoin('o.tours', 't')
            ->leftJoin('o.languages', 'l')
            ->leftJoin('t.tests', "tt")
            ->leftJoin("tt.variants", 'v')
            ->leftJoin("v.userTests", 'ut')
            ->where('t.publishedAt is NOT NULL')
            ->andWhere('ut.user = :user')
            ->setParameters([
                'user'=>$user
            ])
            ->orderBy('t.startedAt', 'DESC')
            ->getQuery()
            ->getResult();
    }
}
