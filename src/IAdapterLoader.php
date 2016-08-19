<?php

	namespace CzProject\Configuration;


	interface IAdapterLoader extends IAdapter
	{
		/**
		 * @param  string
		 * @return array
		 */
		function loadConfig($file);
	}
