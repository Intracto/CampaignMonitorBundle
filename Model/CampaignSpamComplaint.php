<?php

namespace Intracto\CampaignMonitorBundle\Model;

use Intracto\CampaignMonitorBundle\Exception\MissingRequiredKeyInResult;

/**
 * A subscriber who marked the given campaign as spam, including the subscriber's list ID
 * and the date/time they marked the campaign as spam.
 */
class CampaignSpamComplaint extends CampaignResult
{
    /**
     * @var \DateTime
     */
    private $date;

    /**
     * @param string $listId
     * @param string $email
     * @param \DateTime $date
     */
    public function __construct($listId, $email, \DateTime $date)
    {
        parent::__construct($listId, $email);

        $this->date = $date;
    }

    /**
     * @return array
     */
    public static function getRequiredFields()
    {
        return array_merge(parent::getRequiredFields(), ['Date']);
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

        return new CampaignSpamComplaint(
          $rawData['ListID'],
          $rawData['EmailAddress'],
          $rawData['Date']
        );
    }

    /**
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }
}
