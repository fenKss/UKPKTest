<?php

namespace App\Repository;

use App\Entity\Test;
use App\Entity\Variant;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Variant|null find($id, $lockMode = null, $lockVersion = null)
 * @method Variant|null findOneBy(array $criteria, array $orderBy = null)
 * @method Variant[]    findAll()
 * @method Variant[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VariantRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Variant::class);
    }

    /**
     * @return int|mixed|string
     */
    public function getByTestWithQuestions(Test $test)
    {
        return $this->createQueryBuilder('v')
            ->select('v, q')
            ->leftJoin('v.questions', 'q')
            ->where('v.test = :test')
            ->setParameters([
                'test' => $test
            ])
            ->getQuery()
            ->getResult();
    }

}
