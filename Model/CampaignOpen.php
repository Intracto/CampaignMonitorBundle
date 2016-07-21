<?php

namespace Intracto\CampaignMonitorBundle\Model;

use Intracto\CampaignMonitorBundle\Exception\MissingRequiredKeyInResult;

/**
 * A subscriber who opened a given campaign, including the date/time and IP address from which they opened the campaign.
 *
 * When possible, the latitude, longitude, city, region, country code, and country name
 * as geocoded from the IP address, are also returned.
 */
class CampaignOpen extends CampaignResult
{
    /**
     * @var \DateTime
     */
    private $date;

    /**
     * @var string
     */
    private $ipAddress;

    /**
     * @var string
     */
    private $latitude;

    /**
     * @var string
     */
    private $longitude;

    /**
     * @var string
     */
    private $city;

    /**
     * @var string
     */
    private $region;

    /**
     * @var string
     */
    private $countryCode;

    /**
     * @var string
     */
    private $countryName;

    /**
     * @param string $listId
     * @param string $email
     * @param \DateTime $date
     * @param string $ipAddress
     */
    public function __construct(
      $listId,
      $email,
      \DateTime $date,
      $ipAddress
    ) {
        parent::__construct($listId, $email);

        $this->date = $date;
        $this->ipAddress = $ipAddress;
    }

    /**
     * @return array
     */
    public static function getRequiredFields()
    {
        return array_merge(parent::getRequiredFields(), ['Date', 'IPAddress']);
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

        $campaignOpen = new CampaignOpen(
          $rawData['ListID'],
          $rawData['EmailAddress'],
          $rawData['Date'],
          $rawData['IPAddress']
        );

        if (isset($rawData['Latitude'])) {
            $campaignOpen->setLatitude($rawData['Latitude']);
        }

        if (isset($rawData['Longitude'])) {
            $campaignOpen->setLongitude($rawData['Longitude']);
        }

        if (isset($rawData['City'])) {
            $campaignOpen->setCity($rawData['City']);
        }

        if (isset($rawData['Region'])) {
            $campaignOpen->setRegion($rawData['Region']);
        }

        if (isset($rawData['CountryCode'])) {
            $campaignOpen->setCountryCode($rawData['CountryCode']);
        }

        if (isset($rawData['CountryName'])) {
            $campaignOpen->setCountryName($rawData['CountryName']);
        }

        return $campaignOpen;
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
    public function getIpAddress()
    {
        return $this->ipAddress;
    }

    /**
     * @return string|null
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * @return string|null
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * @return string|null
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @return string|null
     */
    public function getRegion()
    {
        return $this->region;
    }

    /**
     * @return string|null
     */
    public function getCountryCode()
    {
        return $this->countryCode;
    }

    /**
     * @return string|null
     */
    public function getCountryName()
    {
        return $this->countryName;
    }

    /**
     * @param string $latitude
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;
    }

    /**
     * @param string $longitude
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;
    }

    /**
     * @param string $city
     */
    public function setCity($city)
    {
        $this->city = $city;
    }

    /**
     * @param string $region
     */
    public function setRegion($region)
    {
        $this->region = $region;
    }

    /**
     * @param string $countryCode
     */
    public function setCountryCode($countryCode)
    {
        $this->countryCode = $countryCode;
    }

    /**
     * @param string $countryName
     */
    public function setCountryName($countryName)
    {
        $this->countryName = $countryName;
    }
}
