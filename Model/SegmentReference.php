<?php

namespace Intracto\CampaignMonitorBundle\Model;

use Intracto\CampaignMonitorBundle\Exception\MissingRequiredKeyInResult;

class SegmentReference implements Hydrateable
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $listId;

    /**
     * @param string $id
     * @param string $title
     * @param string $listId
     */
    public function __construct($id, $title, $listId)
    {
        $this->id = $id;
        $this->title = $title;
        $this->listId = $listId;
    }

    /**
     * @return array
     */
    public static function getRequiredFields()
    {
        return ['SegmentID', 'ListID', 'Title'];
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

        return new SegmentReference($rawData['SegmentID'], $rawData['Title'], $rawData['ListID']);
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
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return mixed
     */
    public function getListId()
    {
        return $this->listId;
    }
}
