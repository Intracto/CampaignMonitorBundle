<?php

namespace Intracto\CampaignMonitorBundle\Model;

abstract class Campaign implements Hydrateable
{
    /**
     * @var string
     */
    protected $id;

    /**
     * The name of the campaign in the admin interface.
     *
     * @var string
     */
    protected $name;

    /**
     * The actual subject of the mailing.
     *
     * @var string
     */
    protected $subject;

    /**
     * @var string
     */
    protected $fromName;

    /**
     * @var string
     */
    protected $fromEmail;

    /**
     * @var string
     */
    protected $replyTo;

    /**
     * @param string $id
     * @param string $name
     * @param string $subject
     * @param string $fromName
     * @param string $fromEmail
     * @param string $replyTo
     */
    public function __construct($id, $name, $subject, $fromName, $fromEmail, $replyTo)
    {
        $this->id = $id;
        $this->name = $name;
        $this->subject = $subject;
        $this->fromName = $fromName;
        $this->fromEmail = $fromEmail;
        $this->replyTo = $replyTo;
    }

    /**
     * @return array
     */
    public static function getRequiredFields()
    {
        return [
          'CampaignID',
          'Name',
          'Subject',
          'FromName',
          'FromEmail',
          'ReplyTo',
        ];
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
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * @return string
     */
    public function getFromName()
    {
        return $this->fromName;
    }

    /**
     * @return string
     */
    public function getFromEmail()
    {
        return $this->fromEmail;
    }

    /**
     * @return string
     */
    public function getReplyTo()
    {
        return $this->replyTo;
    }
}
