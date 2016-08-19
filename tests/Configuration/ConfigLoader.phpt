<?php

use CzProject\Configuration\Adapters;
use CzProject\Configuration\ConfigLoader;
use CzProject\Configuration\IAdapter;
use CzProject\Configuration\IAdapterLoader;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';


Assert::exception(function () {

	$configLoader = new ConfigLoader;
	$configLoader->loadConfig('without-extension');

}, 'CzProject\Configuration\ConfigLoaderException', "Missing extension for file 'without-extension'.");


Assert::exception(function () {

	$configLoader = new ConfigLoader;
	$configLoader->loadConfig('config.JSON');

}, 'CzProject\Configuration\ConfigLoaderException', "Missing adapter for extension 'json', file 'config.JSON'.");


Assert::exception(function () {

	$configLoader = new ConfigLoader;
	$configLoader->addAdapter('json', new Adapters\JsonAdapter);
	@$configLoader->loadConfig(__DIR__ . '/file-not-found/config.JSON'); // @ - intentionally

}, 'CzProject\Configuration\ConfigLoaderException', "Reading of file '" . __DIR__ . "/file-not-found/config.JSON' failed.");


Assert::exception(function () {

	class DummyAdapter implements IAdapter
	{
	}

	$configLoader = new ConfigLoader;
	$configLoader->addAdapter('json', new DummyAdapter);
	$configLoader->loadConfig('config.json');

}, 'CzProject\Configuration\ConfigLoaderException', "Adapter must implement IAdapterLoader or IAdapterParser.");


test(function () {

	class DummyLoaderAdapter implements IAdapterLoader
	{
		public function loadConfig($config)
		{
			return array('dummy', 'loader', 'config');
		}
	}

	$configLoader = new ConfigLoader;
	$configLoader->addAdapter('json', new DummyLoaderAdapter);
	$config = $configLoader->loadConfig('config.json');

	Assert::same(array('dummy', 'loader', 'config'), $config);

});
