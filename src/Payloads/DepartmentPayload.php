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
 * Department payload.
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
class DepartmentPayload extends AbstractPayload
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
		'estrutura' => null,
		'inativo' => null,
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
	 * Set department code.
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
	 * Get department code.
	 *
	 * @since 0.1.0
	 * @return string
	 */
	public function code(): string
	{
		return $this->_get('codigo');
	}

	/**
	 * Set department description.
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
	 * Get department description.
	 *
	 * @since 0.1.0
	 * @return string
	 */
	public function description(): string
	{
		return $this->_get('descricao');
	}

	/**
	 * Set department structure.
	 *
	 * @param mixed $value
	 * @since 0.1.0
	 * @return self
	 */
	public function changeStructure($value)
	{
		$this->_fields['estrutura'] = \strval($value);
		return $this;
	}

	/**
	 * Get department structure.
	 *
	 * @since 0.1.0
	 * @return string|null
	 */
	public function structure(): ?string
	{
		return $this->_get('estrutura');
	}

	/**
	 * Set department as enabled.
	 *
	 * @param mixed $value
	 * @since 0.1.0
	 * @return self
	 */

	public function enabled()
	{
		$this->_fields['inativo'] = 'N';
		return $this;
	}

	/**
	 * Set department as disabled.
	 *
	 * @param mixed $value
	 * @since 0.1.0
	 * @return self
	 */

	public function disabled()
	{
		$this->_fields['inativo'] = 'S';
		return $this;
	}

	/**
	 * Get department status.
	 *
	 * @since 0.1.0
	 * @return string
	 */
	public function isEnabled(): bool
	{
		return $this->_get('inativo', 'N') === 'N';
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

		$p = new DepartmentPayload($body['codigo'], $body['descricao']);
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
			'codigo' => [new Required([ new StringRule(), new MaxLengthRule(40) ])],
			'descricao' => [new Required([ new StringRule(), new MaxLengthRule(60) ])],
			'estrutura' => [new Optional([ new StringRule() ])],
			'inativo' => [new Optional([ new StringRule(), new AllowedValuesRule(['S', 'N']) ])],
		];
	}
}
