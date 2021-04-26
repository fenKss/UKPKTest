<?php

namespace App\Repository;

use App\Entity\Olympic;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @method Olympic|null find($id, $lockMode = null, $lockVersion = null)
 * @method Olympic|null findOneBy(array $criteria, array $orderBy = null)
 * @method Olympic[]    findAll()
 * @method Olympic[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OlympicRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Olympic::class);
    }

    /**
     * @return Olympic[]
     */
    public function getWithAll(): array
    {
        return $this->getWithAllQuery()
            ->getResult();
    }

    /**
     * @return Query
     */
    public function getWithAllQuery(): Query
    {
        return $this->createQueryBuilder('o')
            ->select('o,t,l')
            ->leftJoin('o.tours', 't')
            ->leftJoin('o.languages', 'l')
            ->getQuery();
    }

    public function getWithPublishedTours(?int $limit = null)
    {
        return $this->getWithPublishedToursQuery($limit)->getResult();
    }

    public function getWithPublishedToursQuery(?int $limit = null): Query
    {
        $query = $this->createQueryBuilder('o')
            ->select('o,t,l')
            ->leftJoin('o.tours', 't')
            ->leftJoin('o.languages', 'l')
            ->where('t.publishedAt is NOT NULL')
            ->orderBy('t.startedAt', 'DESC')
            ->getQuery()
        ;
        if ($limit) {
            $query->setMaxResults($limit);
        }
        return $query;
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
                'user' => $user
            ])
            ->orderBy('t.startedAt', 'DESC')
            ->getQuery()
            ->getResult();
    }
}
