<?php

	namespace CzProject\Configuration;


	interface IAdapterParser extends IAdapter
	{
		/**
		 * @param  string
		 * @return array
		 */
		function parseConfig($config);
	}
