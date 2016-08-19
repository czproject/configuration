<?php

	namespace CzProject\Configuration;

	use Nette;


	class Helpers
	{
		/**
		 * Expands placeholders (%placeholder%)
		 * @param  mixed
		 * @param  array
		 * @param  bool|array
		 * @return mixed
		 * @throws InvalidArgumentException
		 * @see    https://github.com/nette/di/blob/master/src/DI/Helpers.php
		 */
		public static function expandPlaceholders($var, array $params, $recursive = FALSE)
		{
			if (is_array($var)) {
				$res = array();

				foreach ($var as $key => $val) {
					$res[$key] = self::expandPlaceholders($val, $params, $recursive);
				}

				return $res;

			} elseif (!is_string($var)) {
				return $var;
			}

			$parts = preg_split('#%([\w.-]*)%#i', $var, -1, PREG_SPLIT_DELIM_CAPTURE);
			$res = '';

			foreach ($parts as $n => $part) {
				if ($n % 2 === 0) {
					$res .= $part;

				} elseif ($part === '') {
					$res .= '%';

				} elseif (isset($recursive[$part])) {
					throw new InvalidArgumentException(sprintf('Circular reference detected for variables: %s.', implode(', ', array_keys($recursive))));

				} else {
					try {
						$val = Nette\Utils\Arrays::get($params, explode('.', $part));

					} catch (Nette\InvalidArgumentException $e) {
						throw new InvalidArgumentException("Missing parameter '$part'.", 0, $e);
					}

					if ($recursive) {
						$val = self::expandPlaceholders($val, $params, (is_array($recursive) ? $recursive : array()) + array($part => 1));
					}

					if (strlen($part) + 2 === strlen($var)) {
						return $val;
					}

					if (!is_scalar($val)) {
						throw new InvalidArgumentException("Unable to concatenate non-scalar parameter '$part' into '$var'.");
					}

					$res .= $val;
				}
			}

			return $res;
		}
	}
