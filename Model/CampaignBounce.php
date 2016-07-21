<?php

namespace Intracto\CampaignMonitorBundle\Model;

use Intracto\CampaignMonitorBundle\Exception\MissingRequiredKeyInResult;

/**
 * A subscriber who bounced for a given campaign with related data.
 */
class CampaignBounce extends CampaignResult
{
    const TYPE_HARD = 'Hard';
    const TYPE_SOFT = 'Soft';

    /**
     * @var string
     */
    private $type;

    /**
     * @var string
     */
    private $reason;

    /**
     * @var \DateTime
     */
    private $date;

    /**
     * @param string $listId
     * @param string $email
     * @param string $type
     * @param string $reason
     * @param \DateTime $date
     */
    public function __construct($listId, $email, $type, $reason, \DateTime $date)
    {
        parent::__construct($listId, $email);

        $this->type = $type;
        $this->reason = $reason;
        $this->date = $date;
    }

    /**
     * @return array
     */
    public static function getRequiredFields()
    {
        return array_merge(parent::getRequiredFields(), ['BounceType', 'Date', 'Reason']);
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

        return new CampaignBounce(
          $rawData['ListID'],
          $rawData['EmailAddress'],
          $rawData['BounceType'],
          $rawData['Reason'],
          $rawData['Date']
        );
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getReason()
    {
        return $this->reason;
    }

    /**
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }
}
