<?php

namespace App\Doctrine\ORM\Pagination;

use Doctrine\ORM\Tools\Pagination\Paginator as BasePaginator;

/**
 * Class Paginator.
 */
class Paginator extends BasePaginator
{
    /**
     * @var int
     */
    protected $page = 1;

    /**
     * @var int
     */
    protected $limit;

    /**
     * @const RESULTS_PER_PAGE
     */
    const RESULTS_PER_PAGE = 100;

    /**
     * Paginator constructor.
     *
     * @param $query
     * @param bool $fetchJoinCollection
     * @param int  $resultsPerPage
     */
    public function __construct($query, $fetchJoinCollection = true, $resultsPerPage = self::RESULTS_PER_PAGE)
    {
        parent::__construct($query, $fetchJoinCollection);

        $this->limit = $resultsPerPage;
    }

    /**
     * @param int $page
     * @param int $limit
     *
     * @return Paginator
     */
    public function paginate($page, $limit = null): self
    {
        $page = max(1, $page);

        if (null !== $limit) {
            $this->limit = $limit;
        }

        $this->page = min($page, $this->getTotalPagesCount());

        return $this;
    }

    /**
     * @return int
     */
    public function getPage(): int
    {
        return $this->page;
    }

    /**
     * @return int
     */
    public function getLimit(): int
    {
        return $this->limit;
    }

    /**
     * @return int
     */
    public function getTotalPagesCount(): int
    {
        return (int) ceil($this->count() / $this->getLimit());
    }

    /**
     * @return bool
     */
    public function hasResults(): bool
    {
        return 1 < $this->getTotalPagesCount();
    }

    /**
     * @return bool
     */
    public function canPaginate(): bool
    {
        return $this->page < $this->getTotalPagesCount();
    }

    /**
     * @throws \Doctrine\Common\Persistence\Mapping\MappingException
     *
     * @return \Iterator
     */
    public function getIterator(): \Iterator
    {
        $this->getQuery()->setMaxResults($this->getLimit());
        $this->getQuery()->setFirstResult($this->getFirstResult());

        foreach (parent::getIterator() as $result) {
            yield $result;
        }
    }

    /**
     * @return mixed
     */
    private function getFirstResult()
    {
        return max(0, ($this->getLimit() * ($this->getPage() - 1)));
    }
}