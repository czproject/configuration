<?php

	namespace CzProject\Configuration;


	class ConfigLoader
	{
		/** @var array  [extension => IConfigAdapter] */
		protected $adapters = array();


		/**
		 * @param  string
		 * @return self
		 */
		public function addAdapter($extension, IAdapter $adapter)
		{
			$this->adapters[strtolower($extension)] = $adapter;
			return $this;
		}


		/**
		 * @param  string
		 * @return array
		 * @throws ConfigLoaderException
		 */
		public function loadConfig($file)
		{
			$extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));

			if ($extension === '') {
				throw new ConfigLoaderException("Missing extension for file '$file'.");
			}

			if (!isset($this->adapters[$extension])) {
				throw new ConfigLoaderException("Missing adapter for extension '$extension', file '$file'.");
			}

			$adapter = $this->adapters[$extension];

			if ($adapter instanceof IAdapterLoader) {
				return (array) $adapter->loadConfig($file);
			}

			if ($adapter instanceof IAdapterParser) {
				$content = file_get_contents($file);

				if ($content === FALSE) {
					throw new ConfigLoaderException("Reading of file '$file' failed.");
				}

				return (array) $adapter->parseConfig($content);
			}

			throw new ConfigLoaderException("Adapter must implement IAdapterLoader or IAdapterParser.");
		}
	}
