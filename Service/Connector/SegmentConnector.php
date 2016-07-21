<?php

namespace Intracto\CampaignMonitorBundle\Service\Connector;

use Intracto\CampaignMonitorBundle\Model\Response;
use Intracto\CampaignMonitorBundle\Model\Segment;
use Intracto\CampaignMonitorBundle\Model\Subscriber;
use Intracto\CampaignMonitorBundle\Service\Authentication;
use Intracto\CampaignMonitorBundle\Service\Hydrator;
use Intracto\CampaignMonitorBundle\Service\Paginator;

class SegmentConnector
{
    /**
     * @var string
     */
    private $segmentId;

    /**
     * @var \CS_REST_Segments
     */
    private $segmentsConnection;

    /**
     * @param Authentication $authentication
     * @param string $segmentId
     */
    public function __construct(Authentication $authentication, $segmentId)
    {
        $this->segmentId = $segmentId;
        $this->segmentsConnection = new \CS_REST_Segments($segmentId, $authentication->getDetails());
    }

    /**
     * @return Segment
     */
    public function getDetails()
    {
        $response = new Response($this->segmentsConnection->get());
        $hydrator = new Hydrator(Segment::class);

        return $hydrator->hydrate($response->getContent());
    }

    /**
     * @param int $page
     * @param int $pageSize
     * @param \DateTime $addedSince
     * @param null $orderField
     * @param null $orderDirection
     * @return Paginator
     */
    public function getSubscribers(
      $page = 1,
      $pageSize = 100,
      \DateTime $addedSince = null,
      $orderField = null,
      $orderDirection = null
    )
    {
        $formattedDate = '';

        if ($addedSince instanceof \DateTime) {
            $formattedDate = $addedSince->format('Y-m-d');
        }

        $result = $this->segmentsConnection->get_subscribers($formattedDate, $page, $pageSize, $orderField, $orderDirection);
        $response = new Response($result);

        return new Paginator(
          $response,
          new Hydrator(Subscriber::class),
          [$this, __METHOD__],
          [$page + 1, $pageSize, $addedSince, $orderField, $orderDirection]
        );
    }
}
