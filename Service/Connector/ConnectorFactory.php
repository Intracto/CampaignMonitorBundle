<?php

namespace Intracto\CampaignMonitorBundle\Service\Connector;

interface ConnectorFactory
{
    /**
     * @param string $id
     * @return mixed
     */
    public function getConnectorForId($id);
}
