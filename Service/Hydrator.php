<?php

namespace Intracto\CampaignMonitorBundle\Service;

use Doctrine\Common\Collections\ArrayCollection;
use Intracto\CampaignMonitorBundle\Exception\MissingRequiredKeyInResult;
use Intracto\CampaignMonitorBundle\Exception\ModelIsNotHydrateable;
use Intracto\CampaignMonitorBundle\Model\Hydrateable;

class Hydrator
{
    /**
     * @var string
     */
    private $modelClass;

    /**
     * @param string $modelClass
     * @throws ModelIsNotHydrateable
     */
    public function __construct($modelClass)
    {
        $reflectionClass = new \ReflectionClass($modelClass);

        if (!$reflectionClass->implementsInterface(Hydrateable::class)) {
            throw new ModelIsNotHydrateable('The model class '.$modelClass.' must implement the Hydrateable interface');
        }

        $this->modelClass = $modelClass;
    }

    /**
     * @param array $rawData
     * @return mixed
     * @throws MissingRequiredKeyInResult
     */
    public function hydrate(array $rawData)
    {
        return call_user_func($this->modelClass.'::createFromResultArray', $rawData);
    }

    /**
     * @param array $rawDataSet
     * @return ArrayCollection
     * @throws MissingRequiredKeyInResult
     */
    public function hydrateDataSet(array $rawDataSet)
    {
        $hydratedData = new ArrayCollection();

        foreach ($rawDataSet as $record) {
            $hydratedData->add($this->hydrate($record));
        }

        return $hydratedData;
    }
}
