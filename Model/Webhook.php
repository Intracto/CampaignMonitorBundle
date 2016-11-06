<?php

namespace Intracto\CampaignMonitorBundle\Model;

class Webhook implements Hydrateable
{
    const EVENT_SUBSCRIBE = 'Subscribe';
    const EVENT_DEACTIVATE = 'Deactivate';
    const EVENT_UPDATE = 'Update';
    const PAYLOAD_FORMAT_JSON = 'json';
    const PAYLOAD_FORMAT_XML = 'xml';

    /**
     * @var string
     */
    private $id;

    /**
     * @var array
     */
    private $events;

    /**
     * @var string
     */
    private $url;

    /**
     * @var string
     */
    private $status;

    /**
     * @var string
     */
    private $payloadFormat;

    /**
     * @param string $id
     * @param string $status
     * @param array $events
     * @param string $url
     * @param string $payloadFormat
     */
    public function __construct($id, $status, array $events, $url, $payloadFormat = 'json')
    {
        $this->id = $id;
        $this->status = $status;
        $this->events = $events;
        $this->url = $url;
        $this->payloadFormat = $payloadFormat;
    }

    /**
     * @return array
     */
    public static function getRequiredFields()
    {
        return ['WebhookID', 'Status', 'Events', 'Url', 'PayloadFormat'];
    }

    /**
     * {@inheritdoc}
     */
    public static function createFromResultArray(array $rawData)
    {
        return new Webhook(
            $rawData['WebhookID'],
            $rawData['Status'],
            $rawData['Events'],
            $rawData['Url'],
            $rawData['PayloadFormat']
        );
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return array
     */
    public function getEvents()
    {
        return $this->events;
    }

    /**
     * @param string $event
     * @return bool
     */
    public function hasEvent($event)
    {
        if (in_array($event, $this->events)) {
            return true;
        }

        return false;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @return string
     */
    public function getPayloadFormat()
    {
        return $this->payloadFormat;
    }
}
