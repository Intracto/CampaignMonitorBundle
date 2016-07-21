<?php

namespace Intracto\CampaignMonitorBundle\Model;

use Intracto\CampaignMonitorBundle\Exception\MissingRequiredKeyInResult;

class CampaignSent extends Campaign
{
    /**
     * @var \DateTime
     */
    private $dateSent;

    /**
     * @var int
     */
    private $totalRecipients;

    /**
     * @var string
     */
    private $webVersionURL;

    /**
     * @var string
     */
    private $webVersionTextURL;

    /**
     * @param string $id
     * @param string $name
     * @param string $subject
     * @param string $fromName
     * @param string $fromEmail
     * @param string $replyTo
     * @param \DateTime $dateSent
     * @param int $totalRecipients
     * @param string $webVersionURL
     * @param string $webVersionTextURL
     */
    public function __construct(
      $id,
      $name,
      $subject,
      $fromName,
      $fromEmail,
      $replyTo,
      \DateTime $dateSent,
      $totalRecipients,
      $webVersionURL,
      $webVersionTextURL
    ) {
        parent::__construct($id, $name, $subject, $fromName, $fromEmail, $replyTo);

        $this->dateSent = $dateSent;
        $this->totalRecipients = $totalRecipients;
        $this->webVersionURL = $webVersionURL;
        $this->webVersionTextURL = $webVersionTextURL;
    }

    /**
     * @return array
     */
    public static function getRequiredFields()
    {
        return array_merge(
          parent::getRequiredFields(),
          [
            'SentDate',
            'TotalRecipients',
            'WebVersionURL',
            'WebVersionTextURL',
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

        $rawData['SentDate'] = \DateTime::createFromFormat('Y-m-d H:i:s', $rawData['SentDate']);

        return new CampaignSent(
          $rawData['CampaignID'],
          $rawData['Name'],
          $rawData['Subject'],
          $rawData['FromName'],
          $rawData['FromEmail'],
          $rawData['ReplyTo'],
          $rawData['SentDate'],
          $rawData['TotalRecipients'],
          $rawData['WebVersionURL'],
          $rawData['WebVersionTextURL']
        );
    }

    /**
     * @return \DateTime
     */
    public function getDateSent()
    {
        return $this->dateSent;
    }

    /**
     * @return int
     */
    public function getTotalRecipients()
    {
        return $this->totalRecipients;
    }

    /**
     * @return string
     */
    public function getWebVersionURL()
    {
        return $this->webVersionURL;
    }

    /**
     * @return string
     */
    public function getWebVersionTextURL()
    {
        return $this->webVersionTextURL;
    }
}
