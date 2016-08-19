<?php

use CzProject\Configuration\Adapters;
use CzProject\Configuration\ConfigLoader;
use CzProject\Configuration\Configurator;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';


test(function () {

	$configLoader = new ConfigLoader;
	$configLoader->addAdapter('json', new Adapters\JsonAdapter);

	$configurator = new Configurator($configLoader);
	$configurator->addConfig(__DIR__ . '/assets/config.json');
	$configurator->addConfig(__DIR__ . '/assets/config.local.json');

	Assert::same(array(
		'version' => '2.0.0',
		'branches' => array(
			'master',
			'develop',
		),
	), $configurator->getConfig());

});


Assert::exception(function () {

	$configurator = new Configurator;
	$configurator->addConfig('config.json');

}, 'CzProject\Configuration\ConfiguratorException', 'Missing ConfigLoader.');
