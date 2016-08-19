<?php

use CzProject\Configuration\Adapters;
use Tester\Assert;

require __DIR__ . '/../../bootstrap.php';


test(function () {

	$adapter = new Adapters\JsonAdapter;
	$config = $adapter->parseConfig('{"name": "Gandalf The White", "age": 10000}');

	Assert::same(array(
		'name' => 'Gandalf The White',
		'age' => 10000,
	), $config);

});
