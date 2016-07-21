<?php

namespace Intracto\CampaignMonitorBundle\Model;

use Intracto\CampaignMonitorBundle\Exception\MissingRequiredKeyInResult;

class ListDetails implements Hydrateable
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
     * @var bool
     */
    private $confirmedOptIn;

    /**
     * @var string
     */
    private $unsubscribePage;

    /**
     * @var string
     */
    private $unsubscribeSetting;

    /**
     * @var string
     */
    private $confirmationSuccessPage;

    /**
     * @param string $id
     * @param string $title
     * @param bool $confirmedOptIn
     * @param string $unsubscribePage
     * @param string $unsubscribeSetting
     * @param string $confirmationSuccessPage
     */
    public function __construct(
      $id,
      $title,
      $confirmedOptIn,
      $unsubscribePage,
      $unsubscribeSetting,
      $confirmationSuccessPage
    ) {
        $this->id = $id;
        $this->title = $title;
        $this->confirmedOptIn = $confirmedOptIn;
        $this->unsubscribePage = $unsubscribePage;
        $this->unsubscribeSetting = $unsubscribeSetting;
        $this->confirmationSuccessPage = $confirmationSuccessPage;
    }

    /**
     * @return array
     */
    public static function getRequiredFields()
    {
        return [
          'ListID',
          'Title',
          'ConfirmedOptIn',
          'UnsubscribePage',
          'UnsubscribeSetting',
          'ConfirmationSuccessPage',
        ];
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

        return new ListDetails(
          $rawData['ListID'],
          $rawData['Title'],
          $rawData['ConfirmedOptIn'],
          $rawData['UnsubscribePage'],
          $rawData['UnsubscribeSetting'],
          $rawData['ConfirmationSuccessPage']
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
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return boolean
     */
    public function isConfirmedOptIn()
    {
        return $this->confirmedOptIn;
    }

    /**
     * @return string
     */
    public function getUnsubscribePage()
    {
        return $this->unsubscribePage;
    }

    /**
     * @return string
     */
    public function getUnsubscribeSetting()
    {
        return $this->unsubscribeSetting;
    }

    /**
     * @return string
     */
    public function getConfirmationSuccessPage()
    {
        return $this->confirmationSuccessPage;
    }
}
