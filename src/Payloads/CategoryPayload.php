<?php

namespace Pgly\Omie\Api\Payloads;

use InvalidArgumentException;
use Piggly\ApiClient\Payloads\AbstractPayload;
use Piggly\ApiClient\Payloads\Rules\AllowedValuesRule;
use Piggly\ApiClient\Payloads\Rules\MaxLengthRule;
use Piggly\ApiClient\Payloads\Rules\Optional;
use Piggly\ApiClient\Payloads\Rules\Required;
use Piggly\ApiClient\Payloads\Rules\StringRule;

/**
 * Category payload.
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
class CategoryPayload extends AbstractPayload
{
	/**
	 * All payload fields.
	 *
	 * @var array
	 * @since 0.1.0
	 */
	protected $_fields = [
		'codigo' => null,
		'descricao' => null,
		'natureza' => null,
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
	 * Set category code.
	 *
	 * @param mixed $value
	 * @since 0.1.0
	 * @return self
	 */
	public function changeCode($value)
	{
		$this->_fields['codigo'] = \strval($value);
		return $this;
	}

	/**
	 * Get category code.
	 *
	 * @since 0.1.0
	 * @return string
	 */
	public function code(): string
	{
		return $this->_get('codigo');
	}

	/**
	 * Set category description.
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
	 * Get category description.
	 *
	 * @since 0.1.0
	 * @return string
	 */
	public function description(): string
	{
		return $this->_get('descricao');
	}

	/**
	 * Set category objective.
	 *
	 * @param mixed $value
	 * @since 0.1.0
	 * @return self
	 */
	public function changeObjective($value)
	{
		$this->_fields['natureza'] = \strval($value);
		return $this;
	}

	/**
	 * Get category objective.
	 *
	 * @since 0.1.0
	 * @return string|null
	 */
	public function Objective(): ?string
	{
		return $this->_get('natureza');
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
		if (!isset($body['codigo'], $body['descricao'])) {
			throw new InvalidArgumentException('`codigo` and `descricao` fields are required.');
		}

		$p = new CategoryPayload($body['codigo'], $body['descricao']);

		if (isset($body['natureza'])) {
			$p->changeObjective($body['natureza']);
		}

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
			'codigo' => [new Required([ new StringRule(), new MaxLengthRule(20) ])],
			'descricao' => [new Required([ new StringRule(), new MaxLengthRule(50) ])],
			'natureza' => [new Optional([ new StringRule() ])],
		];
	}
}
