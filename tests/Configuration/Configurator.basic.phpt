<?php

use CzProject\Configuration\Configurator;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';


test(function () {

	$config = array(
		'parameters' => array(
			'host' => 'localhost',
			'database' => 'database_name',
		),

		'messages' => array(
			'homepage' => 'Homepage',
		),
	);

	$configurator = new Configurator;
	$configurator->addConfig($config);

	Assert::same($config, $configurator->getConfig());

});


test(function () {

	$config = array(
		'parameters' => array(
			'host' => 'localhost',
			'database' => 'database_name',
		),

		'messages' => array(
			'homepage' => 'Homepage',
		),
	);

	$configurator = new Configurator;
	$configurator->addConfig($config);
	$configurator->addConfig(array(
		'parameters' => array(
			'database' => 'testing',
		),

		'messages' => array(
			'about' => 'About',
		),
	));

	Assert::same(array(
		'parameters' => array(
			'host' => 'localhost',
			'database' => 'testing',
		),

		'messages' => array(
			'homepage' => 'Homepage',
			'about' => 'About',
		),
	), $configurator->getConfig());

});
