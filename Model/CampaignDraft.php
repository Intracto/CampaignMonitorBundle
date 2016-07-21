<?php

namespace Intracto\CampaignMonitorBundle\Model;

use Intracto\CampaignMonitorBundle\Exception\MissingRequiredKeyInResult;

class CampaignDraft extends Campaign
{
    /**
     * @var \DateTime
     */
    private $dateCreated;

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
     * @param \DateTime $dateCreated
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
      \DateTime $dateCreated,
      $previewURL,
      $previewTextURL
    ) {
        parent::__construct($id, $name, $subject, $fromName, $fromEmail, $replyTo);

        $this->dateCreated = $dateCreated;
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
            'DateCreated',
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

        $rawData['DateCreated'] = \DateTime::createFromFormat('Y-m-d H:i:s', $rawData['DateCreated']);

        return new CampaignDraft(
          $rawData['CampaignID'],
          $rawData['Name'],
          $rawData['Subject'],
          $rawData['FromName'],
          $rawData['FromEmail'],
          $rawData['ReplyTo'],
          $rawData['DateCreated'],
          $rawData['PreviewURL'],
          $rawData['PreviewTextURL']
        );
    }

    /**
     * @return \DateTime
     */
    public function getDateCreated()
    {
        return $this->dateCreated;
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
