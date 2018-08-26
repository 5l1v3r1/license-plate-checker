<?php

namespace SG\LicensePlate;

use SG\LicensePlate\Checker;

class Detector {
	public static function detect($content) {
		// get the matches
		$matches = [];
		preg_match_all('/([A-Za-z]+\d+[A-Za-z])/', $content, $matches);

		// set the results array
		$results = [];
		
		// iterate through each license plate and add to results if valid
		foreach ($matches[0] as $match) {
			if (Checker::check($match)) {
				array_push($results, $match);
			}
		}

		return $results;
	}
}