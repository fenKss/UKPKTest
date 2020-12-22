<?php


namespace App\Service;

use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

class PaginationService
{
    private $request;

    public function __construct(RequestStack $request_stack)
    {
        $this->request = $request_stack->getCurrentRequest();
    }

    /**
     * @param QueryBuilder|Query $query
     * @param int                $limit
     *
     * @return Paginator
     */
    public function paginate($query, int $limit): Paginator
    {
        $currentPage = $this->request->query->getInt('p') ?: 1;
        $paginator = new Paginator($query);
        $paginator
            ->getQuery()
            ->setFirstResult($limit * ($currentPage - 1))
            ->setMaxResults($limit);
        return $paginator;
    }

    /**
     * @param Paginator $paginator
     *
     * @return int
     */
    public function lastPage(Paginator $paginator): int
    {
        return ceil($paginator->count() / $paginator->getQuery()->getMaxResults());
    }

    /**
     * @param Paginator $paginator
     *
     * @return int
     */
    public function total(Paginator $paginator): int
    {
        return $paginator->count();
    }

    /**
     * @param Paginator $paginator
     *
     * @return bool
     * @throws \Exception
     */
    public function currentPageHasNoResult(Paginator $paginator): bool
    {
        return !$paginator->getIterator()->count();
    }
}