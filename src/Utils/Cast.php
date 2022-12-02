<?php

namespace Pgly\Omie\Api\Utils;

/**
 * Cast one value to another applying modifiers.
 *
 * @package \Pgly\Omie\Api
 * @subpackage \Pgly\Omie\Api\Utils
 * @version 0.1.0
 * @since 0.1.0
 * @category Utils
 * @author Caique Araujo <caique@piggly.com.br>
 * @author Piggly Lab <dev@piggly.com.br>
 * @license MIT
 * @copyright 2022 Piggly Lab <dev@piggly.com.br>
 */
class Cast
{
	/**
	 * Cast original string to uppercase and cut it
	 * based on max length allowed. If max length is
	 * lower than zero (0) does not cut string.
	 *
	 * @param mixed $original
	 * @param integer $max_length
	 * @since 0.1.0
	 * @return string
	 */
	public static function upper($original, int $max_length = -1): string
	{
		$original = \strtoupper(\strval($original));
		return Cast::cut($original, $max_length);
	}

	/**
	 * Cast original string to an string only containing
	 * numbers  and cut it based on max length allowed.
	 * If max length is lower than zero (0) does not cut string.
	 *
	 * @param mixed $original
	 * @since 0.1.0
	 * @return string
	 */
	public static function digit($original, int $max_length = -1): string
	{
		$original = \preg_replace("/[^\d]/i", '', \strval($original));
		return Cast::cut($original, $max_length);
	}

	/**
	 * Cut string to max length allowed.
	 * If max length is lower than zero (0) does not cut string.
	 *
	 * @param mixed $original
	 * @param integer $max_length
	 * @since 0.1.0
	 * @return string
	 */
	public static function cut($original, int $max_length = -1): string
	{
		return $max_length < 0 ? $original : \substr(\strval($original), 0, $max_length);
	}
}
