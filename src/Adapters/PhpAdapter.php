<?php

	namespace CzProject\Configuration\Adapters;

	use CzProject\Configuration\IAdapterLoader;


	class PhpAdapter implements IAdapterLoader
	{
		/**
		 * @param  string
		 * @return array
		 */
		public function loadConfig($file)
		{
			return require $file;
		}
	}
