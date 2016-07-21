<?php

namespace Intracto\CampaignMonitorBundle\Model;

use Intracto\CampaignMonitorBundle\Exception\MissingRequiredKeyInResult;

interface Hydrateable
{
    /**
     * @param array $rawData
     * @return Hydrateable
     * @throws MissingRequiredKeyInResult
     */
    public static function createFromResultArray(array $rawData);
}
