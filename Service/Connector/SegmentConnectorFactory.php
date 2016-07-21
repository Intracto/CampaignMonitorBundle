<?php

namespace Intracto\CampaignMonitorBundle\Service\Connector;

use Intracto\CampaignMonitorBundle\Service\Authentication;

class SegmentConnectorFactory
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
     * @return SegmentConnector
     */
    public function getConnectorForId($id)
    {
        return new SegmentConnector($this->authentication, $id);
    }
}
