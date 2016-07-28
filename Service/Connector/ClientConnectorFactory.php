<?php

namespace Intracto\CampaignMonitorBundle\Service\Connector;

use Intracto\CampaignMonitorBundle\Service\Authentication;

class ClientConnectorFactory implements ConnectorFactory
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
     * @return ClientConnector
     */
    public function getConnectorForId($id)
    {
        return new ClientConnector($this->authentication, $id);
    }
}
