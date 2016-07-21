<?php

namespace Intracto\CampaignMonitorBundle\Model;

use Intracto\CampaignMonitorBundle\Exception\MissingRequiredKeyInResult;

/**
 * A subscriber who unsubscribed from the email for a given campaign,
 * including the date/time and IP address they unsubscribed from.
 */
class CampaignUnsubscribe extends CampaignResult
{
    /**
     * @var \DateTime
     */
    private $date;

    /**
     * @var string
     */
    private $ipAddress;

    /**
     * @param string $listId
     * @param string $email
     * @param \DateTime $date
     * @param string $ipAddress
     */
    public function __construct($listId, $email, \DateTime $date, $ipAddress)
    {
        parent::__construct($listId, $email);

        $this->date = $date;
        $this->ipAddress = $ipAddress;
    }

    /**
     * @return array
     */
    public static function getRequiredFields()
    {
        return array_merge(parent::getRequiredFields(), ['Date', 'IPAddress']);
    }

    /**
     * {@inheritdoc}
     */
    public static function createFromResultArray(array $rawData)
    {
        foreach (static::getRequiredFields() as $field) {
            if (!isset($rawData[$field])) {
                throw new MissingRequiredKeyInResult;
            }
        }

        $rawData['Date'] = \DateTime::createFromFormat('Y-m-d H:i:s', $rawData['Date']);

        return new CampaignUnsubscribe(
          $rawData['ListID'],
          $rawData['EmailAddress'],
          $rawData['Date'],
          $rawData['IPAddress']
        );
    }

    /**
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @return string
     */
    public function getIpAddress()
    {
        return $this->ipAddress;
    }
}
