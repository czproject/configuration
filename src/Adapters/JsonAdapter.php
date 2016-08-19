<?php

	namespace CzProject\Configuration\Adapters;

	use CzProject\Configuration\IAdapterParser;
	use Nette\Utils\Json;


	class JsonAdapter implements IAdapterParser
	{
		/**
		 * @param  string
		 * @return array
		 */
		public function parseConfig($config)
		{
			return Json::decode($config, Json::FORCE_ARRAY);
		}
	}
