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
	 * Check if value may be a CPF or CNPJ.
	 *
	 * @param mixed $cpfOrCnpj
	 * @since 0.1.0
	 * @return boolean
	 */
	public static function cpfOrCnpj($cpfOrCnpj): bool
	{
		if (strlen($cpfOrCnpj) <= 11) {
			return self::cpf($cpfOrCnpj);
		}

		if (strlen($cpfOrCnpj <= 14)) {
			return self::cnpj($cpfOrCnpj);
		}

		return false;
	}

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
	 * Check if a CNPJ is valid.
	 *
	 * @param mixed $cnpj
	 * @since 0.1.0
	 * @return boolean
	 */
	public static function cnpj($cnpj): bool
	{
		$cnpj = Cast::digit($cnpj);

		// Must have a value
		if (empty($cnpj)) {
			return false;
		}

		// Fill with 14 digits
		$cnpj = str_pad($cnpj, 14, '0', STR_PAD_LEFT);

		// Must have 14 digits
		if (strlen($cnpj) != 14) {
			return false;
		}

		// Cannot be a sequence of numbers
		if (
			$cnpj == '00000000000000' ||
			$cnpj == '11111111111111' ||
			$cnpj == '22222222222222' ||
			$cnpj == '33333333333333' ||
			$cnpj == '44444444444444' ||
			$cnpj == '55555555555555' ||
			$cnpj == '66666666666666' ||
			$cnpj == '77777777777777' ||
			$cnpj == '88888888888888' ||
			$cnpj == '99999999999999'
		) {
			return false;
		}

		// Calculate digits
		// First digit
		for ($i = 0, $j = 5, $sum = 0; $i < 12; $i++) {
			$sum += $cnpj[$i] * $j;
			$j = ($j == 2) ? 9 : $j - 1;
		}

		$rest = $sum % 11;

		if ($cnpj[12] != ($rest < 2 ? 0 : 11 - $rest)) {
			return false;
		}

		// Second digit
		for ($i = 0, $j = 6, $sum = 0; $i < 13; $i++) {
			$sum += $cnpj[$i] * $j;
			$j = ($j == 2) ? 9 : $j - 1;
		}

		$rest = $sum % 11;

		return $cnpj[13] == ($rest < 2 ? 0 : 11 - $rest);
	}

	/**
	 * Check if any is a valid email.
	 *
	 * @param mixed $value
	 * @since 0.1.0
	 * @return boolean
	 */
	public static function email($email): bool
	{
		return \filter_var(\strval($email), FILTER_VALIDATE_EMAIL) !== false;
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
		return \ctype_digit(\strval($value));
	}
}
