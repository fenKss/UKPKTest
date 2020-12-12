<?php

namespace App\Repository;

use App\Entity\Variant;
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

    public function getWithAll(Variant $variant, int $question_id = null)
    {
        $qb = $this->createQueryBuilder('q')
            ->select('v, q, qo')
            ->leftJoin('q.questionOptions', 'qo')
            ->leftJoin('q.variant', 'v')
            ->where('v.id = :variant')
            ->setParameters([
                'variant' => $variant
            ]);
        if ($question_id) {
            $qb->andWhere('q.id = :question_id')
                ->setParameter('question_id', $question_id);
        }
        return $qb->getQuery()
            ->getResult();
    }
}
