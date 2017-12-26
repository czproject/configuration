
# CzProject\Configuration

Helper for processing of configurations.

## Installation

[Download a latest package](https://github.com/czproject/configuration/releases) or use [Composer](http://getcomposer.org/):

```
composer require czproject/configuration
```

`CzProject\Configuration` requires PHP 5.4.0 or later.


## Usage

``` php
<?php

use CzProject\Configuration\Configurator;

$configurator = new Configurator;
$configurator->addConfig(array(
	'database' => array(
		'host' => 'localhost',
	),
));

$configurator->addConfig(array(
	'database' => array(
		'user' => 'user123',
		'password' => 'password123',
	),
));

$config = $configurator->getConfig();

/* Returns:
[
	database => [
		host => 'localhost',
		user => 'user123',
		password => 'password123',
	]
]
*/
```


### Config files

``` php
<?php

use CzProject\Configuration\Configurator;
use CzProject\Configuration\ConfigLoader;
use CzProject\Configuration\Adapters;

$loader = new ConfigLoader;
$loader->addAdapter('json', Adapters\JsonAdapter);
$loader->addAdapter('php', Adapters\PhpAdapter);

$configurator = new Configurator($loader);
$configurator->addConfig('config.json');
$configurator->addConfig('config.local.php');

$config = $configurator->getConfig();
```


### Parameters & placeholders

``` php
<?php

use CzProject\Configuration\Configurator;

$configurator = new Configurator;
$configurator->addConfig(array(
	'parameters' => array(
		'database' => array(
			'host' => 'localhost',
			'driver' => 'mysql',
		),
	),

	'messages' => array(
		'user' => '%database.user%',
	),
));

$configurator->addConfig(array(
	'parameters' => array(
		'database' => array(
			'user' => '%database.host%_user123',
			'password' => 'password123',
		),
	),
));

$config = $configurator->getConfigExpandedBy('parameters');

/* Returns:
[
	parameters => [
		database => [
			host => 'localhost',
			driver => 'mysql',
			user => 'localhost_user123',
			password => 'password123',
		]
	],

	messages => [
		user => 'localhost_user123',
	]
]
*/
```

------------------------------

License: [New BSD License](license.md)
<br>Author: Jan Pecha, https://www.janpecha.cz/
