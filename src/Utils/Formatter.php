<?php

namespace Pgly\Omie\Api\Utils;

use DateTimeImmutable;
use Piggly\ApiClient\Payloads\AbstractPayload;

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
	 * Take a CNPJ string and format it as 00.000.000/0000-00.
	 *
	 * @package mixed $cnpj
	 * @since 0.1.0
	 * @return string
	 */
	public static function cnpj($cnpj): string
	{
		return \preg_replace('/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/', '$1.$2.$3/$4-$5', Cast::digit($cnpj));
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

	/**
	 * Take a date string and create a DateTimeImutable object.
	 *
	 * @param mixed $date
	 * @since 0.1.0
	 * @return DateTimeImmutable
	 * @todo Timezone
	 */
	public static function date($date): DateTimeImmutable
	{
		if ($date instanceof DateTimeImmutable) {
			return $date;
		}

		return new DateTimeImmutable($date);
	}

	/**
	 * Create a DateTimeImutable object from now.
	 *
	 * @since 0.1.0
	 * @return DateTimeImmutable
	 * @todo Timezone
	 */
	public static function now(): DateTimeImmutable
	{
		return new DateTimeImmutable();
	}

	/**
	 * Prepare request body.
	 *
	 * @param ApplicationModel $app
	 * @param string $method
	 * @param AbstractPayload $body
	 * @since 0.1.0
	 * @return array
	 */
	public static function requestBody($app, string $method, AbstractPayload $body): array
	{
		return [
			'call' => $method,
			'app_key' => $app->get('client_id'),
			'app_secret' => $app->get('client_secret'),
			'param' => [
				$body->toArray()
			]
		];
	}
}
