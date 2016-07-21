<?php

namespace Intracto\CampaignMonitorBundle\Model;

use Intracto\CampaignMonitorBundle\Exception\MissingRequiredKeyInResult;

class CampaignScheduled extends Campaign
{
    /**
     * @var \DateTime
     */
    private $dateScheduled;

    /**
     * @var string
     */
    private $scheduledTimeZone;

    /**
     * @var string
     */
    private $previewURL;

    /**
     * @var string
     */
    private $previewTextURL;

    /**
     * @param string $id
     * @param string $name
     * @param string $subject
     * @param string $fromName
     * @param string $fromEmail
     * @param string $replyTo
     * @param \DateTime $dateScheduled
     * @param string $scheduledTimeZone
     * @param string $previewURL
     * @param string $previewTextURL
     */
    public function __construct(
      $id,
      $name,
      $subject,
      $fromName,
      $fromEmail,
      $replyTo,
      \DateTime $dateScheduled,
      $scheduledTimeZone,
      $previewURL,
      $previewTextURL
    ) {
        parent::__construct($id, $name, $subject, $fromName, $fromEmail, $replyTo);

        $this->dateScheduled = $dateScheduled;
        $this->scheduledTimeZone = $scheduledTimeZone;
        $this->previewURL = $previewURL;
        $this->previewTextURL = $previewTextURL;
    }

    /**
     * @return array
     */
    public static function getRequiredFields()
    {
        return array_merge(
          parent::getRequiredFields(),
          [
            'DateScheduled',
            'ScheduledTimeZone',
            'PreviewURL',
            'PreviewTextURL',
          ]
        );
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

        $rawData['DateScheduled'] = \DateTime::createFromFormat('Y-m-d H:i:s', $rawData['DateScheduled']);

        return new CampaignScheduled(
          $rawData['CampaignID'],
          $rawData['Name'],
          $rawData['Subject'],
          $rawData['FromName'],
          $rawData['FromEmail'],
          $rawData['ReplyTo'],
          $rawData['DateScheduled'],
          $rawData['ScheduledTimeZone'],
          $rawData['PreviewURL'],
          $rawData['PreviewTextURL']
        );
    }

    /**
     * @return \DateTime
     */
    public function getDateScheduled()
    {
        return $this->dateScheduled;
    }

    /**
     * @return string
     */
    public function getScheduledTimeZone()
    {
        return $this->scheduledTimeZone;
    }

    /**
     * @return string
     */
    public function getPreviewURL()
    {
        return $this->previewURL;
    }

    /**
     * @return string
     */
    public function getPreviewTextURL()
    {
        return $this->previewTextURL;
    }
}
