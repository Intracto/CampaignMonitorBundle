# IntractoCampaignMonitorBundle

Welcome to the IntractoCampaignMonitorBundle - a Symfony wrapper for the Campaign Monitor PHP library.

For details on how to get started with IntractoCampaignMonitorBundle, keep on reading.

## What's inside?

The IntractoCampaignMonitorBundle has following features:
- All results from the API are hydrated to different models.
- Paged results are returned as a Paginator instance with a method to get the next set of records.
- A defensive programming approach in all classes to prevent broken instances.

All code included in the IntractoCampaignMonitorBundle is released under the MIT or BSD license.

## Installation

### Step 1 - Install IntractoCampaignMonitorBundle using composer
Edit your composer.json to include the bundle as a dependency.

```js
{
    "require": {
        "intracto/campaign-monitor-bundle": "0.1",
    }
}
```

Open up a command line window and tell composer to download the new dependency.

``` bash
$ php composer.phar update intracto/campaign-monitor-bundle
```

### Step 2 - Register the bundle in your AppKernel file


``` php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        ...
        new Intracto\CampaignMonitorBundle\IntractoCampaignMonitorBundle(),
    );
}
```

### Configure the bundle to use your Campaign Monitor API key

``` yml
// app/config/config.yml

intracto_campaign_monitor:
    api_key: YOUR_API_KEY

```

## Usage
There are 4 factory services at your disposal.

- itr.campaign_monitor.factory.client_connector
- itr.campaign_monitor.factory.list_connector
- itr.campaign_monitor.factory.segment_connector
- itr.campaign_monitor.factory.campaign_connector

Each of these services implements the ConnectorFactory interface, which has one public method 'getConnectorForId', which accepts an id in the form of a string and returns a Connector. 

Here is an example of how to use the ClientConnectorFactory service.

``` php
<?php

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ClientController extends Controller
{
	/**
	* @var Request $request
	* @return Response
	*/
	public function subscriberListsAction(Request $request)	
	{
		$clientConnectorFactory = $this->get('itr.campaign_monitor.factory.client_connector');
		
		$clientId = $this->getParameter('your_client_id');
		$clientConnector = $clientConnectorFactory->getConnectorForId($clientId);
		
		/** @var ListReference[]|ArrayCollection $lists */
		$lists = $clientConnector->getLists();
		
		return $this->render('your_template_file.html.twig', ['lists' => $lists]);
	}
	
	...
}

```
Have a look inside the Connector classes to check out what methods are available. Nearly all methods will return a response in OOP-style.

Paginated results like subscribers lists, will be put into a Paginator instance. This class has a next() method, that will execute another request to the Campaign Monitor API for the next page.

Not all methods of the CampaignMonitor API are available yet. If some are missing, feel free to open up an issue. 

Pull requests are also greatly appreciated!
