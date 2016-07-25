<?php

namespace Intracto\CampaignMonitorBundle\Service\Connector;

use Intracto\CampaignMonitorBundle\Model\ListDetails;
use Intracto\CampaignMonitorBundle\Model\Response;
use Intracto\CampaignMonitorBundle\Model\Subscriber;
use Intracto\CampaignMonitorBundle\Service\Authentication;
use Intracto\CampaignMonitorBundle\Service\Hydrator;
use Intracto\CampaignMonitorBundle\Service\Paginator;

class ListConnector
{
    /**
     * @var string
     */
    private $listId;

    /**
     * @var \CS_REST_Subscribers
     */
    private $subscribersConnection;

    /**
     * @var \CS_REST_Lists
     */
    private $listConnection;

    /**
     * @param Authentication $authentication
     * @param string $listId
     */
    public function __construct(Authentication $authentication, $listId)
    {
        $this->listId = $listId;
        $this->subscribersConnection = new \CS_REST_Subscribers($listId, $authentication->getDetails());
        $this->listConnection = new \CS_REST_Lists($listId, $authentication->getDetails());
    }

    /**
     * @return ListDetails
     */
    public function getDetails()
    {
        $response = new Response($this->listConnection->get());
        $hydrator = new Hydrator(ListDetails::class);

        return $hydrator->hydrate($response->getContent());
    }

    /**
     * @return Response
     */
    public function getStats()
    {
        return new Response($this->listConnection->get_stats());
    }

    /**
     * @param string $email
     * @param string|null $name
     * @param array $customFields
     * @param bool $resubscribe
     * @param bool $restartSubscription Set to true to trigger any automated workflows
     * @return Response
     */
    public function addSubscriber(
      $email,
      $name = null,
      $customFields = [],
      $resubscribe = false,
      $restartSubscription = false
    ) {
        $subscriberDetails = [
          'EmailAddress' => $email,
          'CustomFields' => $customFields,
          'Resubscribe' => $resubscribe,
          'RestartSubscriptionBasedAutoResponders' => $restartSubscription,
        ];

        if ($name !== null) {
            $subscriberDetails['Name'] = $name;
        }

        $result = $this->subscribersConnection->add($subscriberDetails);

        return new Response($result);
    }

    /**
     * @param string $email
     * @return Subscriber
     */
    public function getSubscriber($email)
    {
        $response = new Response($this->subscribersConnection->get($email));
        $hydrator = new Hydrator(Subscriber::class);

        return $hydrator->hydrate($response->getContent());
    }

    /**
     * @param string $email
     * @return Response
     */
    public function getSubscriberHistory($email)
    {
        return new Response($this->subscribersConnection->get_history($email));
    }

    /**
     * @param string $email
     * @return Response
     */
    public function unsubscribeSubscriber($email)
    {
        return new Response($this->subscribersConnection->unsubscribe($email));
    }

    /**
     * @param string $email
     * @return Response
     */
    public function deleteSubscriber($email)
    {
        return new Response($this->subscribersConnection->delete($email));
    }

    /**
     * @param string $email
     * @param string|null $name Leaving this value to null will not empty the field
     * @param array $customFields This array should be of following form
     *      array(
     *          array(
     *              'Key' => The custom fields personalisation tag
     *              'Value' => The value for this subscriber
     *              'Clear' => true/false (pass true to remove this custom field.
     *          )
     *      )
     * @param bool $resubscribe
     * @param bool $restartSubscription Set to true to trigger any automated workflows
     * @return Response
     */
    public function updateSubscriber(
      $email,
      $name = null,
      $customFields = [],
      $resubscribe = false,
      $restartSubscription = false
    ) {
        $response = $this->subscribersConnection->update($email, [
          'EmailAddress' => $email,
          'Name' => $name,
          'CustomFields' => $customFields,
          'Resubscribe' => $resubscribe,
          'RestartSubscriptionBasedAutoResponders' => $restartSubscription,
        ]);

        return new Response($response);
    }

    /**
     * @param int $page
     * @param int $pageSize
     * @param \DateTime $addedSince The date to start getting subscribers from
     * @param string $orderField The field to order the record set by ('EMAIL', 'NAME', 'DATE')
     * @param string $orderDirection The direction to order the record set ('ASC', 'DESC')
     * @return Paginator
     */
    public function getActiveSubscribers(
      $page = 1,
      $pageSize = 100,
      \DateTime $addedSince = null,
      $orderField = null,
      $orderDirection = null
    ) {
        $formattedDate = '';

        if ($addedSince instanceof \DateTime) {
            $formattedDate = $addedSince->format('Y-m-d');
        }

        $result = $this->listConnection->get_active_subscribers($formattedDate, $page, $pageSize, $orderField, $orderDirection);
        $response = new Response($result);

        return new Paginator(
          $response,
          new Hydrator(Subscriber::class),
          [$this, __METHOD__],
          [$page + 1, $pageSize, $addedSince, $orderField, $orderDirection]
        );
    }

    /**
     * @param int $page
     * @param int $pageSize
     * @param \DateTime $addedSince The date to start getting subscribers from
     * @param string $orderField The field to order the record set by ('EMAIL', 'NAME', 'DATE')
     * @param string $orderDirection The direction to order the record set ('ASC', 'DESC')
     * @return Paginator
     */
    public function getUnconfirmedSubscribers(
      $page = 1,
      $pageSize = 100,
      \DateTime $addedSince = null,
      $orderField = null,
      $orderDirection = null
    ) {
        $formattedDate = '';

        if ($addedSince instanceof \DateTime) {
            $formattedDate = $addedSince->format('Y-m-d');
        }

        $result = $this->listConnection->get_unconfirmed_subscribers($formattedDate, $page, $pageSize, $orderField, $orderDirection);
        $response = new Response($result);

        return new Paginator(
          $response,
          new Hydrator(Subscriber::class),
          [$this, __METHOD__],
          [$page + 1, $pageSize, $addedSince, $orderField, $orderDirection]
        );
    }

    /**
     * @param int $page
     * @param int $pageSize
     * @param \DateTime $addedSince The date to start getting subscribers from
     * @param string $orderField The field to order the record set by ('EMAIL', 'NAME', 'DATE')
     * @param string $orderDirection The direction to order the record set ('ASC', 'DESC')
     * @return Paginator
     */
    public function getBouncedSubscribers(
      $page = 1,
      $pageSize = 100,
      \DateTime $addedSince = null,
      $orderField = null,
      $orderDirection = null
    ) {
        $formattedDate = '';

        if ($addedSince instanceof \DateTime) {
            $formattedDate = $addedSince->format('Y-m-d');
        }

        $result = $this->listConnection->get_bounced_subscribers($formattedDate, $page, $pageSize, $orderField, $orderDirection);
        $response = new Response($result);

        return new Paginator(
          $response,
          new Hydrator(Subscriber::class),
          [$this, __METHOD__],
          [$page + 1, $pageSize, $addedSince, $orderField, $orderDirection]
        );
    }


    /**
     * @param int $page
     * @param int $pageSize
     * @param \DateTime $addedSince The date to start getting subscribers from
     * @param string $orderField The field to order the record set by ('EMAIL', 'NAME', 'DATE')
     * @param string $orderDirection The direction to order the record set ('ASC', 'DESC')
     * @return Paginator
     */
    public function getUnsubscribers(
      $page = 1,
      $pageSize = 100,
      \DateTime $addedSince = null,
      $orderField = null,
      $orderDirection = null
    ) {
        $formattedDate = '';

        if ($addedSince instanceof \DateTime) {
            $formattedDate = $addedSince->format('Y-m-d');
        }

        $result = $this->listConnection->get_unsubscribed_subscribers($formattedDate, $page, $pageSize, $orderField, $orderDirection);
        $response = new Response($result);

        return new Paginator(
          $response,
          new Hydrator(Subscriber::class),
          [$this, __METHOD__],
          [$page + 1, $pageSize, $addedSince, $orderField, $orderDirection]
        );
    }

    /**
     * @return Response
     */
    public function getSegments()
    {
        return new Response($this->listConnection->get_segments());
    }

    /**
     * @return Response
     */
    public function getCustomFields()
    {
        return new Response($this->listConnection->get_custom_fields());
    }
}
