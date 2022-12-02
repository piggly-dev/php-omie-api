<?php

namespace Pgly\Omie\Api\Utils;

/**
 * Validate any value based in rules.
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
class Validator
{
	/**
	 * Check if a CPF is valid.
	 *
	 * @param mixed $cpf
	 * @since 0.1.0
	 * @return boolean
	 */
	public static function cpf($cpf): bool
	{
		$cpf = Cast::digit($cpf);

		// Must have a value
		if (empty($cpf)) {
			return false;
		}

		// Fill with 11 digits
		$cpf = str_pad($cpf, 11, '0', STR_PAD_LEFT);

		// Must have 11 digits
		if (strlen($cpf) != 11) {
			return false;
		}

		// Cannot be a sequence of numbers
		if (
			$cpf == '00000000000' ||
			$cpf == '11111111111' ||
			$cpf == '22222222222' ||
			$cpf == '33333333333' ||
			$cpf == '44444444444' ||
			$cpf == '55555555555' ||
			$cpf == '66666666666' ||
			$cpf == '77777777777' ||
			$cpf == '88888888888' ||
			$cpf == '99999999999'
		) {
			return false;
		}

		// Calculate digits
		for ($t = 9; $t < 11; $t++) {
			for ($d = 0, $c = 0; $c < $t; $c++) {
				$d += $cpf[$c] * (($t + 1) - $c);
			}

			$d = ((10 * $d) % 11) % 10;

			if ($cpf[$c] != $d) {
				return false;
			}
		}

		return true;
	}

	/**
	 * Check if any is a digit.
	 *
	 * @param mixed $value
	 * @since 0.1.0
	 * @return boolean
	 */
	public static function digit($value): bool
	{
		return \ctype_digit($value);
	}
}
