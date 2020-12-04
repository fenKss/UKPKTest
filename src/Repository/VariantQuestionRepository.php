<?php

namespace App\Repository;

use App\Entity\VariantQuestion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method VariantQuestion|null find($id, $lockMode = null, $lockVersion = null)
 * @method VariantQuestion|null findOneBy(array $criteria, array $orderBy = null)
 * @method VariantQuestion[]    findAll()
 * @method VariantQuestion[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VariantQuestionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, VariantQuestion::class);
    }

    // /**
    //  * @return VariantQuestion[] Returns an array of VariantQuestion objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('v.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?VariantQuestion
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
