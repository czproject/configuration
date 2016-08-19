<?php

use CzProject\Configuration\Adapters;
use Tester\Assert;

require __DIR__ . '/../../bootstrap.php';


test(function () {

	$file = Tester\FileMock::create('<?php
		return array(
			"name" => "Gandalf The White",
			"age" => 10000,
		);
	');

	$adapter = new Adapters\PhpAdapter;
	$config = $adapter->loadConfig($file);

	Assert::same(array(
		'name' => 'Gandalf The White',
		'age' => 10000,
	), $config);

});
