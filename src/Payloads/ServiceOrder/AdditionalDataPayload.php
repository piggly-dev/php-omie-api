<?php

namespace Pgly\Omie\Api\Payloads\ServiceOrder;

use InvalidArgumentException;
use Piggly\ApiClient\Payloads\AbstractPayload;
use Piggly\ApiClient\Payloads\Rules\IntegerRule;
use Piggly\ApiClient\Payloads\Rules\MaxLengthRule;
use Piggly\ApiClient\Payloads\Rules\Required;
use Piggly\ApiClient\Payloads\Rules\StringRule;

/**
 * Additional Data payload structure.
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
class AdditionalDataPayload extends AbstractPayload
{
	/**
	 * All payload fields.
	 *
	 * @var array
	 * @since 0.1.0
	 */
	protected $_fields = [
		'cCidPrestServ' => null, /** required */
		'cCodCateg' => null, /** required */
		'cDadosAdicNF' => null, /** required */
		'nCodCC' => null, /** required */
	];

	/**
	 * Construct object with required fields.
	 *
	 * @param mixed $cCidPrestServ
	 * @param mixed $cCodCateg
	 * @param mixed $cDadosAdicNF
	 * @param mixed $nCodCC
	 * @since 0.1.0
	 */
	public function __construct($cCidPrestServ, $cCodCateg, $cDadosAdicNF, $nCodCC)
	{
		$this
			->changeCity($cCidPrestServ)
			->changeCategory($cCodCateg)
			->changeObservations($cDadosAdicNF)
			->changeBankAccount($nCodCC);
	}

	/**
	 * Change cCidPrestServ field.
	 *
	 * @param mixed $city
	 * @since 0.1.0
	 * @return self
	 */
	public function changeCity($city)
	{
		$this->_field['cCidPrestServ'] = \strval($city);
		return $this;
	}

	/**
	 * Change cCodCateg field.
	 *
	 * @param mixed $code
	 * @since 0.1.0
	 * @return self
	 */
	public function changeCategory($code)
	{
		$this->_field['cCodCateg'] = \strval($code);
		return $this;
	}

	/**
	 * Change cDadosAdicNF field.
	 *
	 * @param mixed $data
	 * @since 0.1.0
	 * @return self
	 */
	public function changeObservations($data)
	{
		$this->_field['cDadosAdicNF'] = \strval($data);
		return $this;
	}

	/**
	 * Change nCodCC field.
	 *
	 * @param mixed $code
	 * @since 0.1.0
	 * @return self
	 */
	public function changeBankAccount($code)
	{
		$this->_field['nCodCC'] = \intval($code);
		return $this;
	}

	/**
	 * Get cCidPrestServ field.
	 *
	 * @since 0.1.0
	 * @return string
	 */
	public function city(): string
	{
		return $this->_get('cCidPrestServ');
	}

	/**
	 * Get cCodCateg field.
	 *
	 * @since 0.1.0
	 * @return string
	 */
	public function category(): string
	{
		return $this->_get('cCodCateg');
	}

	/**
	 * Get cDadosAdicNF field.
	 *
	 * @since 0.1.0
	 * @return string
	 */
	public function observations(): string
	{
		return $this->_get('cDadosAdicNF');
	}

	/**
	 * Get nCodCC field.
	 *
	 * @since 0.1.0
	 * @return int
	 */
	public function bankAccount(): int
	{
		return $this->_get('nCodCC');
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
		if (!isset($body['cCidPrestServ'], $body['cCodCateg'], $body['cDadosAdicNF'], $body['nCodCC'])) {
			throw new InvalidArgumentException('`cCidPrestServ`, `cCodCateg`, `cDadosAdicNF` and `nCodCC` fields are required.');
		}

		$p = new AdditionalDataPayload($body['cCidPrestServ'], $body['cCodCateg'], $body['cDadosAdicNF'], $body['nCodCC']);
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
			'cCidPrestServ' => [new Required([ new StringRule(), new MaxLengthRule(40) ])], /** required */
			'cCodCateg' => [new Required([ new StringRule(), new MaxLengthRule(20) ])], /** required */
			'cDadosAdicNF' => [new Required([ new StringRule() ])], /** required */
			'nCodCC' => [new Required([ new IntegerRule() ])], /** required */
		];
	}
}
