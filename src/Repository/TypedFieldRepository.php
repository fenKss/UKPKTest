<?php

namespace App\Repository;

use App\Entity\TypedField;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TypedField|null find($id, $lockMode = null, $lockVersion = null)
 * @method TypedField|null findOneBy(array $criteria, array $orderBy = null)
 * @method TypedField[]    findAll()
 * @method TypedField[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TypedFieldRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TypedField::class);
    }

    // /**
    //  * @return TypedField[] Returns an array of TypedField objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?TypedField
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
