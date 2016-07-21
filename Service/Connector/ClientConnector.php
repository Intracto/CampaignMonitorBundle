<?php

namespace Intracto\CampaignMonitorBundle\Service\Connector;

use Doctrine\Common\Collections\ArrayCollection;
use Intracto\CampaignMonitorBundle\Model\CampaignDraft;
use Intracto\CampaignMonitorBundle\Model\CampaignScheduled;
use Intracto\CampaignMonitorBundle\Model\CampaignSent;
use Intracto\CampaignMonitorBundle\Model\ListReference;
use Intracto\CampaignMonitorBundle\Model\Response;
use Intracto\CampaignMonitorBundle\Model\SegmentReference;
use Intracto\CampaignMonitorBundle\Service\Authentication;
use Intracto\CampaignMonitorBundle\Service\Hydrator;

class ClientConnector
{
    /**
     * @var string
     */
    private $segmentId;

    /**
     * @var \CS_REST_Clients
     */
    private $clientConnection;

    /**
     * @param Authentication $authentication
     * @param string $clientId
     */
    public function __construct(Authentication $authentication, $clientId)
    {
        $this->segmentId = $clientId;
        $this->clientConnection = new \CS_REST_Clients($clientId, $authentication->getDetails());
    }

    /**
     * @return Response
     */
    public function getDetails()
    {
        return new Response($this->clientConnection->get());
    }

    /**
     * @return ListReference[]|ArrayCollection
     */
    public function getLists()
    {
        $response = new Response($this->clientConnection->get_lists());
        $hydrator = new Hydrator(ListReference::class);

        return $hydrator->hydrateDataSet($response->getContent());
    }

    /**
     * @return SegmentReference[]|ArrayCollection
     */
    public function getSegments()
    {
        $response = new Response($this->clientConnection->get_segments());
        $hydrator = new Hydrator(SegmentReference::class);

        return $hydrator->hydrateDataSet($response->getContent());
    }

    /**
     * @return CampaignSent[]|ArrayCollection
     */
    public function getCampaignsSent()
    {
        $response = new Response($this->clientConnection->get_campaigns());
        $hydrator = new Hydrator(CampaignSent::class);

        return $hydrator->hydrateDataSet($response->getContent());
    }

    /**
     * @return CampaignScheduled[]|ArrayCollection
     */
    public function getCampaignsScheduled()
    {
        $response = new Response($this->clientConnection->get_scheduled());
        $hydrator = new Hydrator(CampaignScheduled::class);

        return $hydrator->hydrateDataSet($response->getContent());
    }

    /**
     * @return CampaignDraft[]|ArrayCollection
     */
    public function getCampaignsDrafts()
    {
        $response = new Response($this->clientConnection->get_drafts());
        $hydrator = new Hydrator(CampaignDraft::class);

        return $hydrator->hydrateDataSet($response->getContent());
    }
}
