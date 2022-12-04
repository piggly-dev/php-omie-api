<?php

namespace Pgly\Omie\Api\Payloads;

use InvalidArgumentException;
use Pgly\Omie\Api\Utils\Cast;
use Pgly\Omie\Api\Utils\Formatter;
use Piggly\ApiClient\Payloads\AbstractPayload;
use Piggly\ApiClient\Payloads\Rules\IntegerRule;
use Piggly\ApiClient\Payloads\Rules\MaxLengthRule;
use Piggly\ApiClient\Payloads\Rules\Optional;
use Piggly\ApiClient\Payloads\Rules\Required;
use Piggly\ApiClient\Payloads\Rules\StringRule;

/**
 * Address payload structure with required fields as
 * cep and optional fields as endereco, endereco_numero,
 * complemento, bairro, estado and cidade.
 *
 * @package Pgly\Omie\Api
 * @subpackage Pgly\Omie\Api\Payloads
 * @version 0.1.0
 * @since 0.1.0
 * @category Payloads
 * @author Caique Araujo <caique@piggly.com.br>
 * @author Piggly Lab <dev@piggly.com.br>
 * @license MIT
 * @copyright 2022 Piggly Lab <dev@piggly.com.br>
 */
class CityPayload extends AbstractPayload
{
	/**
	 * All payload fields.
	 *
	 * @var array
	 * @since 0.1.0
	 */
	protected $_fields = [
		'cCod' => null,
		'cNome' => null,
		'cUF' => null,
		'nCodIBGE' => null,
		'nCodSIAFI' => null,
	];


	/**
	 * Construct object with required fields.
	 *
	 * @param mixed $code
	 * @param mixed $name
	 * @param mixed $uf
	 * @param mixed $ibge
	 * @param mixed $siafi
	 * @since 0.1.0
	 * @return void
	 */
	public function __construct(
		$code,
		$name,
		$uf,
		$ibge,
		$siafi
	) {
		$this
			->changeCode($code)
			->changeName($name)
			->changeState($uf)
			->changeIbgeCode($ibge)
			->changeSiafiCode($siafi);
	}

	/**
	 * Set city code.
	 *
	 * @param mixed $value
	 * @since 0.1.0
	 * @return self
	 */
	public function changeCode($value)
	{
		$this->_fields['cCod'] = \strval($value);
		return $this;
	}

	/**
	 * Set city name.
	 *
	 * @param mixed $value
	 * @since 0.1.0
	 * @return self
	 */
	public function changeName($value)
	{
		$this->_fields['cNome'] = \strval($value);
		return $this;
	}

	/**
	 * Set city state.
	 *
	 * @param mixed $value
	 * @since 0.1.0
	 * @return self
	 */
	public function changeState($value)
	{
		$this->_fields['cUF'] = \strval($value);
		return $this;
	}

	/**
	 * Set city IBGE code.
	 *
	 * @param mixed $value
	 * @since 0.1.0
	 * @return self
	 */
	public function changeIbgeCode($value)
	{
		$this->_fields['nCodIBGE'] = \intval($value);
		return $this;
	}

	/**
	 * Set city SIAFI code.
	 *
	 * @param mixed $value
	 * @since 0.1.0
	 * @return self
	 */
	public function changeSiafiCode($value)
	{
		$this->_fields['nCodSIAFI'] = \intval($value);
		return $this;
	}

	/**
	 * Get city code.
	 *
	 * @since 0.1.0
	 * @return string
	 */
	public function code(): string
	{
		return $this->_get('cCod');
	}

	/**
	 * Get city name.
	 *
	 * @since 0.1.0
	 * @return string
	 */
	public function name(): string
	{
		return $this->_get('cNome');
	}

	/**
	 * Get city state.
	 *
	 * @since 0.1.0
	 * @return string
	 */
	public function state(): string
	{
		return $this->_get('cUF');
	}

	/**
	 * Get city IBGE code.
	 *
	 * @since 0.1.0
	 * @return integer
	 */
	public function ibgeCode(): int
	{
		return $this->_get('nCodIBGE');
	}

	/**
	 * Get city SIAFI code.
	 *
	 * @since 0.1.0
	 * @return integer
	 */
	public function siafiCode(): int
	{
		return $this->_get('nCodSIAFI');
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
		if (!isset($body['cCod'], $body['cNome'], $body['cUF'], $body['nCodIBGE'], $body['nCodSIAFI'])) {
			throw new InvalidArgumentException('`cCod`, `cNome`, `cUF`, `nCodIBGE` and `nCodSIAFI` fields are required.');
		}

		$p = new CityPayload($body['cCod'], $body['cNome'], $body['cUF'], $body['nCodIBGE'], $body['nCodSIAFI']);
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
			'cCod' => [new Optional([ new StringRule(), new MaxLengthRule(60) ])],
			'cNome' => [new Optional([ new StringRule(), new MaxLengthRule(60) ])],
			'cUF' => [new Optional([ new StringRule(), new MaxLengthRule(2) ])],
			'nCodIBGE' => [new Optional([ new IntegerRule() ])],
			'nCodSIAFI' => [new Optional([ new IntegerRule() ])]
		];
	}
}
