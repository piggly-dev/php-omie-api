<?php

namespace Pgly\Omie\Api\Payloads\ServiceOrder;

use InvalidArgumentException;
use Piggly\ApiClient\Payloads\AbstractPayload;
use Piggly\ApiClient\Payloads\Rules\AllowedValuesRule;
use Piggly\ApiClient\Payloads\Rules\FloatRule;
use Piggly\ApiClient\Payloads\Rules\IntegerRule;
use Piggly\ApiClient\Payloads\Rules\Optional;
use Piggly\ApiClient\Payloads\Rules\Required;
use Piggly\ApiClient\Payloads\Rules\StringRule;

/**
 * Service payload structure.
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
class ServicePayload extends AbstractPayload
{
	/**
	 * All payload fields.
	 *
	 * @var array
	 * @since 0.1.0
	 */
	protected $_fields = [
		'nCodServico' => null, /** required */
		'nQtde' => 1, /** required */
		'nValUnit' => null, /** required */
		'cTpDesconto' => null,
		'nValorDesconto' => null,
	];

	/**
	 * Construct object with required fields.
	 *
	 * @param mixed $nCodServico
	 * @param mixed $nQtde
	 * @param mixed $nValUnit
	 * @since 0.1.0
	 */
	public function __construct($nCodServico, $nQtde, $nValUnit)
	{
		$this->changeCode($nCodServico)
			->changeQuantity($nQtde)
			->changeAmount($nValUnit);
	}

	/**
	 * Change nCodServico field.
	 *
	 * @param mixed $code
	 * @since 0.1.0
	 * @return self
	 */
	public function changeCode($code)
	{
		$this->_field['nCodServico'] = \intval($code);
		return $this;
	}

	/**
	 * Change nQtde field.
	 *
	 * @param mixed $quantity
	 * @since 0.1.0
	 * @return self
	 */
	public function changeQuantity($quantity)
	{
		$this->_field['nQtde'] = \intval($quantity);
		return $this;
	}

	/**
	 * Change nValUnit field.
	 *
	 * @param mixed $value
	 * @since 0.1.0
	 * @return self
	 */
	public function changeAmount($value)
	{
		$this->_field['nValUnit'] = \floatval($value);
		return $this;
	}

	/**
	 * Change cTpDesconto field.
	 *
	 * @param mixed $type
	 * @since 0.1.0
	 * @return self
	 */
	public function changeDiscountType($type)
	{
		$this->_field['cTpDesconto'] = \strval($type);
		return $this;
	}

	/**
	 * Change nValorDesconto field.
	 *
	 * @param mixed $value
	 * @since 0.1.0
	 * @return self
	 */
	public function changeDiscountAmount($value)
	{
		$this->_field['nValorDesconto'] = \floatval($value);
		return $this;
	}

	/**
	 * Get nCodServico field.
	 *
	 * @since 0.1.0
	 * @return int
	 */
	public function code(): int
	{
		return $this->_get('nCodServico');
	}

	/**
	 * Get nQtde field.
	 *
	 * @since 0.1.0
	 * @return int
	 */
	public function quantity(): int
	{
		return $this->_get('nQtde');
	}

	/**
	 * Get nValUnit field.
	 *
	 * @since 0.1.0
	 * @return float
	 */
	public function amount(): float
	{
		return $this->_get('nValUnit');
	}

	/**
	 * Get cTpDesconto field.
	 *
	 * @since 0.1.0
	 * @return string|null
	 */
	public function discountType(): ?string
	{
		return $this->_get('cTpDesconto');
	}

	/**
	 * Get nValorDesconto field.
	 *
	 * @since 0.1.0
	 * @return float|null
	 */
	public function discountAmount(): ?float
	{
		return $this->_get('nValorDesconto');
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
		if (!isset($body['nCodServico'], $body['nQtde'], $body['nValUnit'])) {
			throw new InvalidArgumentException('`nCodServico`, `nQtde` and `nValUnit` fields are required.');
		}

		$p = new ServicePayload($body['nCodServico'], $body['nQtde'], $body['nValUnit']);
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
			'nCodServico' => [new Required([ new IntegerRule() ])], /** required */
			'nQtde' => [new Required([ new IntegerRule() ])], /** required */
			'nValUnit' => [new Required([ new FloatRule() ])], /** required */
			'cTpDesconto' => [new Optional([ new StringRule(), new AllowedValuesRule(['V', 'P']) ])], /** required */
			'nValorDesconto' => [new Optional([ new FloatRule() ])], /** required */
		];
	}
}
