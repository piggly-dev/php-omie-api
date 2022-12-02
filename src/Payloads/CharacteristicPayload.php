<?php

namespace Pgly\Omie\Api\Payloads;

use InvalidArgumentException;
use Pgly\Omie\Api\Utils\Cast;
use Piggly\ApiClient\Payloads\AbstractPayload;
use Piggly\ApiClient\Payloads\Rules\MaxLengthRule;
use Piggly\ApiClient\Payloads\Rules\Required;
use Piggly\ApiClient\Payloads\Rules\StringRule;

/**
 * Characteristic payload structure with required campo and conteudo fields.
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
class CharacteristicPayload extends AbstractPayload
{
	/**
	 * All payload fields.
	 *
	 * @var array
	 * @since 0.1.0
	 */
	protected $_fields = [
		'campo' => null,
		'conteudo' => null
	];

	/**
	 * Construct object with required fields.
	 *
	 * @param string $campo
	 * @param string $conteudo
	 * @since 0.1.0
	 * @return void
	 */
	public function __construct(string $campo, string $conteudo)
	{
		$this->changeCampo($campo);
		$this->changeConteudo($conteudo);
	}

	/**
	 * Get campo.
	 *
	 * @since 0.1.0
	 * @return string
	 */
	public function campo(): string
	{
		return $this->_get('campo');
	}

	/**
	 * Change campo field.
	 *
	 * @param mixed $campo
	 * @since 0.1.0
	 * @return self
	 */
	public function changeCampo($campo)
	{
		$this->_fields['campo'] = Cast::cut($campo, 30);
		return $this;
	}

	/**
	 * Get conteudo.
	 *
	 * @since 0.1.0
	 * @return string
	 */
	public function conteudo(): string
	{
		return $this->_get('conteudo');
	}

	/**
	 * Change conteudo field.
	 *
	 * @param mixed $conteudo
	 * @since 0.1.0
	 * @return self
	 */
	public function changeConteudo($conteudo)
	{
		$this->_fields['conteudo'] = Cast::cut($conteudo, 60);
		return $this;
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
		if (!isset($body['campo'], $body['conteudo'])) {
			throw new InvalidArgumentException('`campo` and `conteudo` fields are required.');
		}

		$p = new CharacteristicPayload($body['campo'], $body['conteudo']);
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
			'campo' => [new Required([ new StringRule(), new MaxLengthRule(30) ])],
			'conteudo' => [new Required([ new StringRule(), new MaxLengthRule(60) ])]
		];
	}
}
