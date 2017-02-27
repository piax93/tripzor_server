<?php
class Util {

	public static function compareDate($startDate, $endDate) {
		$s = date_parse_from_format ( "Y-n-j", $startDate );
		$e = date_parse_from_format ( "Y-n-j", $endDate );
		return $e ['year'] > $s ['year']
			|| ($e ['year'] == $s ['year'] && $e ['month'] > $s ['month'])
			|| ($e ['year'] == $s ['year'] && $e ['month'] == $s ['month'] && $e ['day'] >= $s ['day']);
	}

}
