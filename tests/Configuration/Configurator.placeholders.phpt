<?php

use CzProject\Configuration\Configurator;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';


test(function () {

	$config = array(
		'parameters' => array(
			'host' => 'localhost',
			'database' => 'testing',
			'password' => '%user%_1234',
			'user' => '%database%_admin',
			'notifications' => array(
				'email' => 'notifications@example.com',
				'logLevel' => 10,
			),
		),

		'messages' => array(
			'homepage' => 'Homepage',
			'notifications' => '%notifications.email%',
			'url' => '%user%@%host%',
			'productivity' => '100%',
			'marker' => '%%',
			'placeholder' => '%%placeholder%%',
		),
	);

	$configurator = new Configurator;
	$configurator->addConfig($config);

	Assert::same(array(
		'parameters' => array(
			'host' => 'localhost',
			'database' => 'testing',
			'password' => 'testing_admin_1234',
			'user' => 'testing_admin',
			'notifications' => array(
				'email' => 'notifications@example.com',
				'logLevel' => 10,
			),
		),

		'messages' => array(
			'homepage' => 'Homepage',
			'notifications' => 'notifications@example.com',
			'url' => 'testing_admin@localhost',
			'productivity' => '100%',
			'marker' => '%',
			'placeholder' => '%placeholder%',
		),
	), $configurator->getConfigExpandedBy('parameters'));

});


Assert::exception(function () {

	$config = array(
		'parameters' => array(
			'host' => '%server%',
			'database' => '%host%',
		),
	);

	$configurator = new Configurator;
	$configurator->addConfig($config);
	$configurator->getConfigExpandedBy('parameters');

}, 'CzProject\Configuration\InvalidArgumentException', "Missing parameter 'server'.");


Assert::exception(function () {

	$config = array(
		'parameters' => array(
			'host' => '%database%_test',
			'database' => array(
				'host' => 'localhost',
			),
		),
	);

	$configurator = new Configurator;
	$configurator->addConfig($config);
	$configurator->getConfigExpandedBy('parameters');

}, 'CzProject\Configuration\InvalidArgumentException', "Unable to concatenate non-scalar parameter 'database' into '%database%_test'.");


Assert::exception(function () {

	$config = array(
		'parameters' => array(
			'host' => '%database%',
			'database' => array(
				'host' => '%host%',
			),
		),
	);

	$configurator = new Configurator;
	$configurator->addConfig($config);
	$configurator->getConfigExpandedBy('parameters');

}, 'CzProject\Configuration\InvalidArgumentException', 'Circular reference detected for variables: database, host.');
