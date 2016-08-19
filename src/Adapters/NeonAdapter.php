<?php

	namespace CzProject\Configuration\Adapters;

	use CzProject\Configuration\IAdapterParser;
	use Nette\Neon\Neon;


	class NeonAdapter implements IAdapterParser
	{
		/**
		 * @param  string
		 * @return array
		 */
		public function parseConfig($config)
		{
			return Neon::decode($config);
		}
	}
