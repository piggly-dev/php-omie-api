<?php

namespace Pgly\Omie\Api\Rules;

use InvalidArgumentException;
use Pgly\Omie\Api\Utils\Cast;
use Pgly\Omie\Api\Utils\Validator;
use Piggly\ApiClient\Interfaces\FixableInterface;
use Piggly\ApiClient\Interfaces\RuleInterface;

/**
 * Assert if value is a CNPJ.
 *
 * @package Pgly\Omie\Api
 * @subpackage Pgly\Omie\Api\Rules
 * @version 0.1.0
 * @since 0.1.0
 * @category Rule
 * @author Caique Araujo <caique@piggly.com.br>
 * @author Piggly Lab <dev@piggly.com.br>
 * @license MIT
 * @copyright 2022 Piggly Lab <dev@piggly.com.br>
 */
class CNPJRule implements RuleInterface, FixableInterface
{
	/**
	 * Assert value and must throw an
	 * exception if invalid.
	 *
	 * @param string $name
	 * @param mixed $value
	 * @since 0.1.0
	 * @return void
	 * @throws InvalidArgumentException
	 */
	public function assert(string $name, $value)
	{
		if (!Validator::cnpj($value)) {
			throw new InvalidArgumentException(\sprintf('%s => O CNPJ é inválido.', $name));
		}
	}

	/**
	 * Fix $value to expected value.
	 * Return $value fixed.
	 *
	 * @param mixed $value
	 * @since 0.1.0
	 * @return mixed
	 */
	public function fix($value)
	{
		if (\is_null($value)) {
			return $value;
		}

		return Cast::digit($value);
	}
}
