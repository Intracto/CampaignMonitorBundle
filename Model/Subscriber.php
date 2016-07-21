<?php

namespace Intracto\CampaignMonitorBundle\Model;

use Intracto\CampaignMonitorBundle\Exception\MissingRequiredKeyInResult;

/**
 * A person subscribed to a certain list including all their data.
 */
class Subscriber implements Hydrateable
{
    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $name;

    /**
     * @var \DateTime
     */
    private $date;

    /**
     * @var string
     */
    private $state;

    /**
     * @var array
     */
    private $customFields;

    /**
     * @var string
     */
    private $readsEmailWith;

    /**
     * @param string $email
     * @param string $name
     * @param \DateTime $date
     * @param string $state
     * @param array $customFields
     * @param string $readsEmailWith
     */
    public function __construct($email, $name, \DateTime $date, $state, $customFields, $readsEmailWith)
    {
        $this->email = $email;
        $this->name = $name;
        $this->date = $date;
        $this->state = $state;
        $this->customFields = $customFields;
        $this->readsEmailWith = $readsEmailWith;

        $this->formatCustomFields();
    }

    /**
     * @return array
     */
    public static function getRequiredFields()
    {
        return ['EmailAddress', 'Name', 'Date', 'State', 'CustomFields', 'ReadsEmailWith'];
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

        $rawData['Date'] = \DateTime::createFromFormat('Y-m-d H:i:s', $rawData['Date']);

        return new Subscriber(
          $rawData['EmailAddress'],
          $rawData['Name'],
          $rawData['Date'],
          $rawData['State'],
          $rawData['CustomFields'],
          $rawData['ReadsEmailWith']
        );
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @return string
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @return array
     */
    public function getCustomFields()
    {
        return $this->customFields;
    }

    /**
     * @param string $fieldName
     * @return bool
     */
    public function hasCustomField($fieldName)
    {
        return isset($this->customFields[$fieldName]);
    }

    /**
     * @param string $fieldName
     * @return null|string
     */
    public function getCustomField($fieldName)
    {
        if ($this->hasCustomField($fieldName)) {
            return $this->customFields[$fieldName];
        }

        return null;
    }

    /**
     * @return string
     */
    public function getReadsEmailWith()
    {
        return $this->readsEmailWith;
    }

    /**
     * Campaign Monitor returns the custom fields in following format
     *
     * array
     *   0 => [
     *    'Key' => '[language]',
     *    'Value' => 'english',
     *   ],
     *   1 => ..
     *
     * This method formats the array so we have the 'Key' value as an array key
     * and the 'Value' value as the array value.
     *
     * It also removes the enclosing square brackets from the array key.
     */
    protected function formatCustomFields()
    {
        $customFieldsFormatted = [];

        $fieldWrappers = ['[', ']'];

        foreach ($this->customFields as $field) {
            $field['Key'] = str_replace($fieldWrappers, '', $field['Key']);
            $customFieldsFormatted[$field['Key']] = $field['Value'];
        }

        $this->customFields = $customFieldsFormatted;
    }
}
