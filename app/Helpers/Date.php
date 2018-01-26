<?php
/**
 * Created by PhpStorm.
 * User: nico
 * Date: 26/01/2018
 * Time: 12:41
 */

namespace App\Helpers;

class Date {

	public static function isValid($date, $format='d/m/Y') {
		if($format == 'd/m/Y') {
			return preg_match('#^(0[1-9]|[12][0-9]|3[01])/(0[1-9]|1[012])/(19|20)\d\d$#', $date);
		}

		return false;
	}

}