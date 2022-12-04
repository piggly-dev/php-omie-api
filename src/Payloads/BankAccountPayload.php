<?php

namespace Pgly\Omie\Api\Payloads;

use InvalidArgumentException;
use Piggly\ApiClient\Payloads\AbstractPayload;
use Piggly\ApiClient\Payloads\Rules\IntegerRule;
use Piggly\ApiClient\Payloads\Rules\MaxLengthRule;
use Piggly\ApiClient\Payloads\Rules\Required;
use Piggly\ApiClient\Payloads\Rules\StringRule;

/**
 * Bank Account payload.
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
class BankAccountPayload extends AbstractPayload
{
	/**
	 * All payload fields.
	 *
	 * @var array
	 * @since 0.1.0
	 */
	protected $_fields = [
		'nCodCC' => null,
		'descricao' => null,
	];

	/**
	 * Constructor.
	 *
	 * @param mixed $code
	 * @param mixed $description
	 * @since 0.1.0
	 * @return void
	 */

	public function __construct($code = null, $description = null)
	{
		$this
			->changeCode($code)
			->changeDescription($description);
	}

	/**
	 * Set bank account code.
	 *
	 * @param mixed $value
	 * @since 0.1.0
	 * @return self
	 */
	public function changeCode($value)
	{
		$this->_fields['nCodCC'] = \intval($value);
		return $this;
	}

	/**
	 * Get bank account code.
	 *
	 * @since 0.1.0
	 * @return int
	 */
	public function code(): int
	{
		return $this->_get('nCodCC');
	}

	/**
	 * Set bank account description.
	 *
	 * @param mixed $value
	 * @since 0.1.0
	 * @return self
	 */
	public function changeDescription($value)
	{
		$this->_fields['descricao'] = \strval($value);
		return $this;
	}

	/**
	 * Get bank account description.
	 *
	 * @since 0.1.0
	 * @return string
	 */
	public function description(): string
	{
		return $this->_get('descricao');
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
		if (!isset($body['nCodCC'], $body['descricao'])) {
			throw new InvalidArgumentException('`nCodCC` and `descricao` fields are required.');
		}

		$p = new BankAccountPayload($body['nCodCC'], $body['descricao']);
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
			'nCodCC' => [new Required([ new IntegerRule() ])],
			'descricao' => [new Required([ new StringRule(), new MaxLengthRule(50) ])],
		];
	}
}
