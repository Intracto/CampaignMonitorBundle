<?php

namespace Intracto\CampaignMonitorBundle\Service\Connector;

use Intracto\CampaignMonitorBundle\Service\Authentication;

class CampaignConnectorFactory
{
    /**
     * @var Authentication
     */
    private $authentication;

    /**
     * @param Authentication $authentication
     */
    public function __construct(Authentication $authentication)
    {
        $this->authentication = $authentication;
    }

    /**
     * @param string $id
     * @return CampaignConnector
     */
    public function getConnectorForId($id)
    {
        return new CampaignConnector($this->authentication, $id);
    }
}
