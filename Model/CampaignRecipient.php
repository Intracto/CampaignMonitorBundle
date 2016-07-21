<?php

namespace Intracto\CampaignMonitorBundle\Model;

use Intracto\CampaignMonitorBundle\Exception\MissingRequiredKeyInResult;

/**
 * A subscriber who received a certain campaign.
 */
class CampaignRecipient extends CampaignResult
{
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

        $recipient = new CampaignRecipient($rawData['ListID'], $rawData['EmailAddress']);

        return $recipient;
    }
}
