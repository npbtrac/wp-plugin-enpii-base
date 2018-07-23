<?php
/**
 * Created by PhpStorm.
 * Author: npbtrac@yahoo.com
 * Date time: 12/1/17 1:44 PM
 */

namespace Enpii\WpEnpiiCore;

class Common {

	/**
	 * Fulfill a link with http or https
	 * @param string $link to be fulfilled
	 * @param boolean $https using https or not in the result
	 *
	 * @return string complete url with protcal
	 */
	public static function fulfill_link($link, $https = false)
	{
		$link = strtolower($link);
		$link = !$link || substr($link, 0, 7) == 'http://' || substr($link, 0,
			8) == 'https://' ? $link : $https ? 'https' : 'http' . '://' . $link;

		return $link;
	}

	/**
	 * Get a substring from beginning to a position without space, tab ...
	 * @param $str
	 * @param $end
	 * @param $replace
	 *
	 * @return bool|string
	 */
	public static function get_substring($str, $end, $replace)
	{
		if (strlen($str) > $end) {
			$str = substr($str, 0, $end);
			return preg_replace('/\W\w+\s*(\W*)$/', '$1', $str) . $replace;
		}
		return $str;
	}

	/**
	 * Convert a date time from GMT time zone to another
	 *
	 * @param $time_zone
	 * @param null $format
	 * @param null $date_time
	 *
	 * @return string
	 */
	public static function convert_time_zone($time_zone, $format = null, $date_time = null)
	{
		date_default_timezone_set('Europe/London');
		if (empty($format)) {
			$format = 'Y-m-d H:i:s';
		}
		if (empty($date_time)) {
			$date_time = date($format);
		}
		$obj_date_time = new \DateTime($date_time);
		$obj_date_time->format($format);
		$la_time = new \DateTimeZone($time_zone);
		$obj_date_time->setTimezone($la_time);
		return $obj_date_time->format($format);
	}
}