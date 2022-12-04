<?php

namespace Pgly\Omie\Api\Payloads\ServiceOrder;

use InvalidArgumentException;
use Piggly\ApiClient\Payloads\AbstractPayload;
use Piggly\ApiClient\Payloads\Rules\AllowedValuesRule;
use Piggly\ApiClient\Payloads\Rules\FloatRule;
use Piggly\ApiClient\Payloads\Rules\IntegerRule;
use Piggly\ApiClient\Payloads\Rules\MaxLengthRule;
use Piggly\ApiClient\Payloads\Rules\Required;
use Piggly\ApiClient\Payloads\Rules\StringRule;

/**
 * Department payload structure.
 *
 * @package Pgly\Omie\Api
 * @subpackage Pgly\Omie\Api\Payloads\ServiceOrder
 * @version 0.1.0
 * @since 0.1.0
 * @category Payloads
 * @author Caique Araujo <caique@piggly.com.br>
 * @author Piggly Lab <dev@piggly.com.br>
 * @license MIT
 * @copyright 2022 Piggly Lab <dev@piggly.com.br>
 */
class DepartmentPayload extends AbstractPayload
{
	/**
	 * All payload fields.
	 *
	 * @var array
	 * @since 0.1.0
	 */
	protected $_fields = [
		'cCodDepto' => null, /** required */
		'nPerc' => null, /** required */
		'nValor' => null, /** required */
		'nValorFixo' => 'N',
	];

	/**
	 * Construct object with required fields.
	 *
	 * @param mixed $cCodDepto
	 * @param mixed $nPerc
	 * @param mixed $nValor
	 * @since 0.1.0
	 */
	public function __construct($cCodDepto, $nPerc, $nValor)
	{
		$this->changeCode($cCodDepto)
			->changePercentage($nPerc)
			->changeAmount($nValor);
	}

	/**
	 * Change cCodDepto field.
	 *
	 * @param mixed $code
	 * @since 0.1.0
	 * @return self
	 */
	public function changeCode($code)
	{
		$this->_field['cCodDepto'] = \strval($code);
		return $this;
	}

	/**
	 * Change nPerc field.
	 *
	 * @param mixed $perc
	 * @since 0.1.0
	 * @return self
	 */
	public function changePercentage($perc)
	{
		$this->_field['nPerc'] = \intval($perc);
		return $this;
	}

	/**
	 * Change nValor field.
	 *
	 * @param mixed $value
	 * @since 0.1.0
	 * @return self
	 */
	public function changeAmount($value)
	{
		$this->_field['nValor'] = \floatval($value);
		return $this;
	}

	/**
	 * Change nValorFixo field.
	 *
	 * @param boolean $value
	 * @since 0.1.0
	 * @return self
	 */
	public function changeFixedAmount(bool $value)
	{
		$this->_field['nValorFixo'] = $value ? 'S' : 'N';
		return $this;
	}

	/**
	 * Get cCodDepto field.
	 *
	 * @since 0.1.0
	 * @return string
	 */
	public function code(): string
	{
		return $this->_get('cCodDepto');
	}

	/**
	 * Get nPerc field.
	 *
	 * @since 0.1.0
	 * @return int
	 */
	public function percentage(): int
	{
		return $this->_get('nPerc');
	}

	/**
	 * Get nValor field.
	 *
	 * @since 0.1.0
	 * @return float
	 */
	public function amount(): float
	{
		return $this->_get('nValor');
	}

	/**
	 * Get nValorFixo field.
	 *
	 * @since 0.1.0
	 * @return string
	 */
	public function fixedAmount(): string
	{
		return $this->_get('nValorFixo');
	}

	/**
	 * Import and return the object.
	 *
	 * @param array $body
	 * @since 0.1.0
	 * @return self
	 */
	public static function import(array $body = [])
	{
		if (!isset($body['cCodDepto'], $body['nPerc'], $body['nValor'])) {
			throw new InvalidArgumentException('`cCodDepto`, `nPerc` and `nValor` fields are required.');
		}

		$p = new DepartmentPayload($body['cCodDepto'], $body['nPerc'], $body['nValor']);
		return $p;
	}

	/**
	 * Get payload schema.
	 *
	 * @since 0.1.0
	 * @return array<array<RuleInterface>>
	 */
	protected static function schema(): array
	{
		return [
			'cCodDepto' => [new Required([ new StringRule(), new MaxLengthRule(40) ])], /** required */
			'nPerc' => [new Required([ new IntegerRule() ])], /** required */
			'nValor' => [new Required([ new FloatRule() ])], /** required */
			'nValorFixo' => [new Required([ new StringRule(), new AllowedValuesRule(['S', 'N']) ])], /** required */
		];
	}
}
