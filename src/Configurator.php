<?php

	namespace CzProject\Configuration;

	use CzProject;


	class Configurator
	{
		/** @var array */
		protected $config = array();

		/** @var ConfigLoader */
		protected $configLoader = NULL;


		public function __construct(ConfigLoader $configLoader = NULL)
		{
			$this->configLoader = $configLoader;
		}


		/**
		 * @param  string|array
		 * @return self
		 */
		public function addConfig($config)
		{
			if (!is_array($config)) {
				$config = $this->loadConfig($config);
			}

			$this->config = CzProject\Arrays::merge($config, $this->config);
			return $this;
		}


		/**
		 * @return array
		 */
		public function getConfig()
		{
			return $this->config;
		}


		/**
		 * Expands placeholders (%placeholder%)
		 * @return array
		 */
		public function getConfigExpandedBy($parametersKey)
		{
			$config = $this->config;
			$parameters = isset($config[$parametersKey]) ? $config[$parametersKey] : NULL;

			$parameters = Helpers::expandPlaceholders($parameters, $parameters, TRUE);
			return Helpers::expandPlaceholders($config, $parameters);
		}


		/**
		 * @param  string
		 * @return array
		 * @throws ConfiguratorException
		 */
		protected function loadConfig($file)
		{
			if (!$this->configLoader) {
				throw new ConfiguratorException('Missing ConfigLoader.');
			}
			return $this->configLoader->loadConfig($file);
		}
	}
