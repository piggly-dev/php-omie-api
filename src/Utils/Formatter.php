<?php

namespace Pgly\Omie\Api\Utils;

/**
 * Format any value to another.
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
class Formatter
{
	/**
	 * Take a CPF string and format it as 000.000.000-00.
	 *
	 * @param mixed $cpf
	 * @since 0.1.0
	 * @return string
	 */
	public static function cpf($cpf): string
	{
		return \preg_replace('/(\d{3})(\d{3})(\d{3})(\d{2})/', '$1.$2.$3-$4', Cast::digit($cpf));
	}

	/**
	 * Take a zip code string and format it as 00000-000.
	 *
	 * @param mixed $zipcode
	 * @since 0.1.0
	 * @return string
	 */
	public static function zipcode($zipcode): string
	{
		return preg_replace("/(\d{5})(\d{3})/", "\$1-\$2", Cast::digit($zipcode));
	}

	/**
	 * Take a phone number string and format it as (00) 00000-0000.
	 *
	 * @param mixed $phone
	 * @since 0.1.0
	 * @return string
	 */
	public static function phone($phone): string
	{
		return preg_replace("/(\d{2})(\d{5})(\d{4})/", "(\$1) \$2-\$3", Cast::digit($phone));
	}
}
