<?php

namespace SG\LicensePlate;

class Checker {
	/** @var array Contains all the multipliers for the checksum. **/
	protected static $multipliers = [ 9, 4, 5, 4, 3, 2 ];

	/** @var array Contains all the checksum letters from the calculation. **/
	protected static $letters = [ 'A', 'Z', 'Y', 'X', 'U', 'T', 'S', 'R', 'P', 'M', 'L', 'K', 'J', 'H', 'G', 'E', 'D', 'C', 'B' ];

	/**
	 * Checks whether the license plate is valid.
	 * 
	 * @param string $licensePlate License Plate
	 * @return boolean Valid/Invalid/Maybe
	 */
	public static function check($string) {
		// do preliminary checks - reject if longer than 8 characters
		if (strlen($string) > 8) return false;

		// uppercase all portions of the string
		$string = preg_replace('/(\s)+/', '', strtoupper($string));

		$fragments = preg_split('/([A-Za-z]+)(\d+)([A-Za-z])/', $string, -1, PREG_SPLIT_DELIM_CAPTURE);
		$fragments = array_values(array_filter($fragments, 'strlen'));

		// if license plate is less than 2 fragemnts,
		// get the last part
		if (sizeof($fragments) < 2) {
			return false;
		}

		foreach ($fragments as $key => &$fragment) {
			if (empty($fragment)) unset($fragment);
			$fragment = self::convertToNumerics($fragment, $key);
		}

		// if license plate is a standard formatted license plate,
		// get the checksum character and verify
		if (sizeof($fragments) == 3) {
			$checksum = self::getChecksumLetter($fragments);

			if ($checksum == implode('', $fragments[2])) {
				return true;
			}
		}

		return false;
	}

	/**
	 * Get the corresponding checksum character.
	 * 
	 * @param string $licensePlate License Plate without Checksum Letter
	 * @return string Checksum Letter
	 */
	public static function getCorrespondingLetter($string) {
		// uppercase all portions of the string
		$string = preg_replace('/(\s)+/', '', strtoupper($string));

		$fragments = preg_split('/([A-Za-z]+)(\d+)/', $string, -1, PREG_SPLIT_DELIM_CAPTURE);
		$fragments = array_values(array_filter($fragments, 'strlen'));

		// if license plate is less than 2 fragemnts,
		// get the last part
		if (sizeof($fragments) != 2) {
			return false;
		}

		foreach ($fragments as $key => &$fragment) {
			if (empty($fragment)) unset($fragment);
			$fragment = self::convertToNumerics($fragment, $key);
		}

		return self::getChecksumLetter($fragments);
	}

	/**
	 * Convert the string to numerics
	 * 
	 * @param string $string
	 * @param integer $index
	 */
	public static function convertToNumerics($string, $index) {
		// make the string an array
		$array = (array)$string;

		// if the string is alphabetical
		if (ctype_alpha($string)) {
			for ($i = 0; $i < strlen($string); $i++) {
				if ($index == 0) $array[$i] = ord($string[$i]) - 64;
			}

			while ($index == 0 && sizeof($array) > 2) {
				array_shift($array);
			}
		}

		else {
			for ($i = 0; $i < strlen($string); $i++) {
				$array[$i] = (int)$string[$i];
			}

			while ($index == 1 && sizeof($array) < 4) {
				array_unshift($array, 0);
			}
		}

		return $array;
	}

	/**
	 * Get the checksum letter based on the first two fragments.
	 * 
	 * @param array $fragments
	 * @return string Checksum
	 */
	public static function getChecksumLetter($fragments) {
		if (sizeof($fragments) == 3) {
			$values = array_merge($fragments[0], $fragments[1]);
			$total = 0;

			foreach ($values as $key => &$value) {
				$value = $value * self::$multipliers[$key];
				$total += $value;
			}

			return self::$letters[$total % 19];
		}
	}
}