<?php

namespace Intracto\CampaignMonitorBundle\Service;

use Doctrine\Common\Collections\ArrayCollection;
use Intracto\CampaignMonitorBundle\Model\Response;

class Paginator implements \Countable
{
    /**
     * @var Response
     */
    private $response;

    /**
     * @var ArrayCollection
     */
    private $records;

    /**
     * @var int
     */
    private $page = 1;

    /**
     * @var int
     */
    private $pages = 1;

    /**
     * @var int
     */
    private $pageSize = 0;

    /**
     * @var int
     */
    private $totalRecordCount = 0;

    /**
     * @var array
     */
    private $callable;

    /**
     * @var array
     */
    private $parameters;

    /**
     * @param Response $response
     * @param Hydrator $hydrator
     * @param array $callable
     * @param array $parameters
     */
    public function __construct(Response $response, Hydrator $hydrator, array $callable, array $parameters)
    {
        if ($response->isPaginated()) {
            $this->page = $response->getContent()['PageNumber'];
            $this->pages = $response->getContent()['NumberOfPages'];
            $this->pageSize = $response->getContent()['PageSize'];
            $this->totalRecordCount = $response->getContent()['TotalNumberOfRecords'];
        }

        $this->response = $response;
        $this->hydrator = $hydrator;
        $this->callable = $callable;
        $this->parameters = $parameters;
        $this->records = $hydrator->hydrateDataSet($response->getContent()['Results']);
    }

    /**
     * @return Paginator
     */
    public function next()
    {
        if ($this->page === $this->pages) {
            $this->records = new ArrayCollection();

            return $this;
        }

        return call_user_func_array($this->callable, $this->parameters);
    }

    /**
     * @return int
     */
    public function count()
    {
        return $this->records->count();
    }

    /**
     * @return int
     */
    public function countTotal()
    {
        if ($this->totalRecordCount) {
            return $this->totalRecordCount;
        }

        return $this->count();
    }

    /**
     * @return array
     */
    public function getRecords()
    {
        return $this->records;
    }

    /**
     * @return bool
     */
    public function containsResult()
    {
        if ($this->count() > 0) {
            return true;
        }

        return false;
    }

    /**
     * @return Response
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * @return int
     */
    public function getPageNumber()
    {
        return $this->page;
    }

    /**
     * @return int
     */
    public function getTotalPages()
    {
        return $this->pages;
    }

    /**
     * @return int
     */
    public function getPageSize()
    {
        return $this->pageSize;
    }
}
