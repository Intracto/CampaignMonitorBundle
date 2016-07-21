<?php

namespace Intracto\CampaignMonitorBundle\Service;

class Authentication
{
    /**
     * @var array
     */
    private $details;

    /**
     * @param string $apiKey
     */
    public function __construct($apiKey)
    {
        $this->details = ['api_key' => $apiKey];
    }

    /**
     * @return array
     */
    public function getDetails()
    {
        return $this->details;
    }
}
