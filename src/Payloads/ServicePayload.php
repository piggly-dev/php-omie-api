<?php

namespace Pgly\Omie\Api\Payloads;

use InvalidArgumentException;
use Piggly\ApiClient\Payloads\AbstractPayload;
use Piggly\ApiClient\Payloads\Rules\IntegerRule;
use Piggly\ApiClient\Payloads\Rules\MaxLengthRule;
use Piggly\ApiClient\Payloads\Rules\Required;
use Piggly\ApiClient\Payloads\Rules\StringRule;

/**
 * Service payload.
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
class ServicePayload extends AbstractPayload
{
	/**
	 * All payload fields.
	 *
	 * @var array
	 * @since 0.1.0
	 */
	protected $_fields = [
		'cCodigo' => null,
		'nCodServ' => null,
		'cDescricao' => null,
	];

	/**
	 * Constructor.
	 *
	 * @param mixed $sku
	 * @param mixed $code
	 * @param mixed $description
	 * @since 0.1.0
	 * @return void
	 */

	public function __construct($sku, $code, $description)
	{
		$this
			->changeSku($sku)
			->changeCode($code)
			->changeDescription($description);
	}

	/**
	 * Set service sku.
	 *
	 * @param mixed $value
	 * @since 0.1.0
	 * @return self
	 */
	public function changeSku($value)
	{
		$this->_fields['cCodigo'] = \strval($value);
		return $this;
	}

	/**
	 * Get service sku.
	 *
	 * @since 0.1.0
	 * @return string
	 */
	public function sku(): string
	{
		return $this->_get('cCodigo');
	}

	/**
	 * Set service code.
	 *
	 * @param mixed $value
	 * @since 0.1.0
	 * @return self
	 */
	public function changeCode($value)
	{
		$this->_fields['nCodServ'] = \intval($value);
		return $this;
	}

	/**
	 * Get service code.
	 *
	 * @since 0.1.0
	 * @return int
	 */
	public function code(): int
	{
		return $this->_get('nCodServ');
	}

	/**
	 * Set service description.
	 *
	 * @param mixed $value
	 * @since 0.1.0
	 * @return self
	 */
	public function changeDescription($value)
	{
		$this->_fields['cDescricao'] = \strval($value);
		return $this;
	}

	/**
	 * Get service description.
	 *
	 * @since 0.1.0
	 * @return string
	 */
	public function description(): string
	{
		return $this->_get('cDescricao');
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
		if (!isset($body['cabecalho'], $body['intListar'])) {
			throw new InvalidArgumentException('`cabecalho` and `intListar` fields are required.');
		}

		$p = new ServicePayload($body['cabecalho']['cCodigo'], $body['intListar']['nCodServ'], $body['cabecalho']['cDescricao']);
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
			'cCodigo' => [new Required([ new StringRule() ])],
			'nCodServ' => [new Required([ new IntegerRule() ])],
			'cDescricao' => [new Required([ new StringRule(), new MaxLengthRule(50) ])],
		];
	}
}
