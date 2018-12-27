
# CzProject\Configuration

[![Build Status](https://travis-ci.org/czproject/configuration.svg?branch=master)](https://travis-ci.org/czproject/configuration)

Helper for processing of configurations.

<a href="https://www.patreon.com/bePatron?u=9680759"><img src="https://c5.patreon.com/external/logo/become_a_patron_button.png" alt="Become a Patron!" height="35"></a>
<a href="https://www.paypal.me/janpecha/1eur"><img src="https://buymecoffee.intm.org/img/button-paypal-white.png" alt="Buy me a coffee" height="35"></a>


## Installation

[Download a latest package](https://github.com/czproject/configuration/releases) or use [Composer](http://getcomposer.org/):

```
composer require czproject/configuration
```

`CzProject\Configuration` requires PHP 5.4.0 or later.


## Usage

``` php
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
use CzProject\Configuration\Configurator;
use CzProject\Configuration\ConfigLoader;
use CzProject\Configuration\Adapters;

$loader = new ConfigLoader;
$loader->addAdapter('json', new Adapters\JsonAdapter);
$loader->addAdapter('php', new Adapters\PhpAdapter);
$loader->addAdapter('neon', new Adapters\NeonAdapter);

$configurator = new Configurator($loader);
$configurator->addConfig('config.json');
$configurator->addConfig('config.local.php');

$config = $configurator->getConfig();
```


### Parameters & placeholders

``` php
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
