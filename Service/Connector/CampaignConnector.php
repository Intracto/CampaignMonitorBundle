<?php

namespace Intracto\CampaignMonitorBundle\Service\Connector;

use Intracto\CampaignMonitorBundle\Model\CampaignBounce;
use Intracto\CampaignMonitorBundle\Model\CampaignClick;
use Intracto\CampaignMonitorBundle\Model\CampaignOpen;
use Intracto\CampaignMonitorBundle\Model\CampaignRecipient;
use Intracto\CampaignMonitorBundle\Model\CampaignSpamComplaint;
use Intracto\CampaignMonitorBundle\Model\CampaignUnsubscribe;
use Intracto\CampaignMonitorBundle\Model\Response;
use Intracto\CampaignMonitorBundle\Service\Authentication;
use Intracto\CampaignMonitorBundle\Service\Hydrator;
use Intracto\CampaignMonitorBundle\Service\Paginator;

class CampaignConnector
{
    /**
     * @var string
     */
    private $campaignId;

    /**
     * @var \CS_REST_Campaigns
     */
    private $campaignsConnection;

    /**
     * @param Authentication $authentication
     * @param string $campaignId
     */
    public function __construct(Authentication $authentication, $campaignId)
    {
        $this->campaignId = $campaignId;
        $this->campaignsConnection = new \CS_REST_Campaigns($campaignId, $authentication->getDetails());
    }

    /**
     * @return Response
     */
    public function getSummary()
    {
        return new Response($this->campaignsConnection->get_summary());
    }

    /**
     * @return Response
     */
    public function getListsAndSegments()
    {
        return new Response($this->campaignsConnection->get_lists_and_segments());
    }

    /**
     * @return Response
     */
    public function getEmailClientUsage()
    {
        return new Response($this->campaignsConnection->get_email_client_usage());
    }

    /**
     * @param int $page
     * @param null $pageSize
     * @param null $orderField
     * @param null $orderDirection
     * @return Paginator
     */
    public function getRecipients(
      $page = 1,
      $pageSize = null,
      $orderField = null,
      $orderDirection = null
    ) {
        $result = $this->campaignsConnection->get_recipients($page, $pageSize, $orderField, $orderDirection);
        $response = new Response($result);

        return new Paginator(
          $response,
          new Hydrator(CampaignRecipient::class),
          [$this, __METHOD__],
          [$page + 1, $pageSize, $orderField, $orderDirection]
        );
    }

    /**
     * @param int $page
     * @param null $pageSize
     * @param \DateTime $addedSince
     * @param null $orderField
     * @param null $orderDirection
     * @return Paginator
     */
    public function getBounces(
      $page = 1,
      $pageSize = null,
      \DateTime $addedSince = null,
      $orderField = null,
      $orderDirection = null
    ) {
        $formattedDate = '';

        if ($addedSince instanceof \DateTime) {
            $formattedDate = $addedSince->format('Y-m-d');
        }

        $result = $this->campaignsConnection->get_bounces(
          $formattedDate,
          $page,
          $pageSize,
          $orderField,
          $orderDirection
        );
        $response = new Response($result);

        return new Paginator(
          $response,
          new Hydrator(CampaignBounce::class),
          [$this, __METHOD__],
          [$page + 1, $pageSize, $addedSince, $orderField, $orderDirection]
        );
    }

    /**
     * @param int $page
     * @param null $pageSize
     * @param \DateTime $addedSince
     * @param null $orderField
     * @param null $orderDirection
     * @return Paginator
     */
    public function getOpens(
      $page = 1,
      $pageSize = null,
      \DateTime $addedSince = null,
      $orderField = null,
      $orderDirection = null
    ) {
        $formattedDate = '';

        if ($addedSince instanceof \DateTime) {
            $formattedDate = $addedSince->format('Y-m-d');
        }

        $result = $this->campaignsConnection->get_opens($formattedDate, $page, $pageSize, $orderField, $orderDirection);
        $response = new Response($result);

        return new Paginator(
          $response,
          new Hydrator(CampaignOpen::class),
          [$this, __METHOD__],
          [$page + 1, $pageSize, $addedSince, $orderField, $orderDirection]
        );
    }

    /**
     * @param int $page
     * @param null $pageSize
     * @param \DateTime $addedSince
     * @param null $orderField
     * @param null $orderDirection
     * @return Paginator
     */
    public function getClicks(
      $page = 1,
      $pageSize = null,
      \DateTime $addedSince = null,
      $orderField = null,
      $orderDirection = null
    ) {
        $formattedDate = '';

        if ($addedSince instanceof \DateTime) {
            $formattedDate = $addedSince->format('Y-m-d');
        }

        $result = $this->campaignsConnection->get_clicks(
          $formattedDate,
          $page,
          $pageSize,
          $orderField,
          $orderDirection
        );
        $response = new Response($result);

        return new Paginator(
          $response,
          new Hydrator(CampaignClick::class),
          [$this, __METHOD__],
          [$page + 1, $pageSize, $addedSince, $orderField, $orderDirection]
        );
    }

    /**
     * @param int $page
     * @param null $pageSize
     * @param \DateTime $addedSince
     * @param null $orderField
     * @param null $orderDirection
     * @return Paginator
     */
    public function getUnsubscribes(
      $page = 1,
      $pageSize = null,
      \DateTime $addedSince = null,
      $orderField = null,
      $orderDirection = null
    ) {
        $formattedDate = '';

        if ($addedSince instanceof \DateTime) {
            $formattedDate = $addedSince->format('Y-m-d');
        }

        $result = $this->campaignsConnection->get_unsubscribes(
          $formattedDate,
          $page,
          $pageSize,
          $orderField,
          $orderDirection
        );
        $response = new Response($result);

        return new Paginator(
          $response,
          new Hydrator(CampaignUnsubscribe::class),
          [$this, __METHOD__],
          [$page + 1, $pageSize, $addedSince, $orderField, $orderDirection]
        );
    }

    /**
     * @param int $page
     * @param null $pageSize
     * @param \DateTime $addedSince
     * @param null $orderField
     * @param null $orderDirection
     * @return Paginator
     */
    public function getSpamComplaints(
      $page = 1,
      $pageSize = null,
      \DateTime $addedSince = null,
      $orderField = null,
      $orderDirection = null
    ) {
        $formattedDate = '';

        if ($addedSince instanceof \DateTime) {
            $formattedDate = $addedSince->format('Y-m-d');
        }

        $result = $this->campaignsConnection->get_spam($formattedDate, $page, $pageSize, $orderField, $orderDirection);
        $response = new Response($result);

        return new Paginator(
          $response,
          new Hydrator(CampaignSpamComplaint::class),
          [$this, __METHOD__],
          [$page + 1, $pageSize, $addedSince, $orderField, $orderDirection]
        );
    }
}
