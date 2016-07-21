<?php

namespace Intracto\CampaignMonitorBundle\Model;

abstract class CampaignResult implements Hydrateable
{
    /**
     * @var string
     */
    protected $listId;

    /**
     * @var string
     */
    protected $email;

    /**
     * @param string $listId
     * @param string $email
     */
    public function __construct($listId, $email)
    {
        $this->listId = $listId;
        $this->email = $email;
    }

    /**
     * @return array
     */
    public static function getRequiredFields()
    {
        return ['ListID', 'EmailAddress'];
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
    public function getEmail()
    {
        return $this->email;
    }
}
