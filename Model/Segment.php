<?php

namespace Intracto\CampaignMonitorBundle\Model;

use Intracto\CampaignMonitorBundle\Exception\MissingRequiredKeyInResult;

/**
 * A targeted sub-group of subscribers based on conditions.
 */
class Segment implements Hydrateable
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $listId;

    /**
     * @var string
     */
    private $title;

    /**
     * @var int
     */
    private $activeSubscribers;

    /**
     * @var array
     */
    private $ruleGroups;

    /**
     * @param string $id
     * @param string $listId
     * @param string $title
     */
    public function __construct($id, $listId, $title)
    {
        $this->id = $id;
        $this->listId = $listId;
        $this->title = $title;
    }

    /**
     * @return array
     */
    public static function getRequiredFields()
    {
        return ['ListID', 'SegmentID', 'Title'];
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

        $segment = new Segment($rawData['SegmentID'], $rawData['ListID'], $rawData['Title']);

        if (isset($rawData['ActiveSubscribers'])) {
            $segment->setActiveSubscribers($rawData['ActiveSubscribers']);
        }

        if (isset($rawData['RuleGroups'])) {
            $segment->setRuleGroups($rawData['RuleGroups']);
        }

        return $segment;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getListId()
    {
        return $this->listId;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return int
     */
    public function getActiveSubscribers()
    {
        return $this->activeSubscribers;
    }

    /**
     * @return array
     */
    public function getRuleGroups()
    {
        return $this->ruleGroups;
    }

    /**
     * @param array $ruleGroups
     */
    public function setRuleGroups($ruleGroups)
    {
        $this->ruleGroups = $ruleGroups;
    }

    /**
     * @param int $activeSubscribers
     */
    public function setActiveSubscribers($activeSubscribers)
    {
        $this->activeSubscribers = $activeSubscribers;
    }
}
