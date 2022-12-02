<?php

namespace Pgly\Omie\Api\Payloads;

use Piggly\ApiClient\Payloads\AbstractPayload;
use Piggly\ApiClient\Payloads\Rules\Required;

/**
 * Characteristic collection payload structure with multiple caracteristicas.
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
class CharacteristicCollectionPayload extends AbstractPayload
{
	/**
	 * All payload fields.
	 *
	 * @var array
	 * @since 0.1.0
	 */
	protected $_fields = [
		'caracteristicas' => []
	];

	/**
	 * Add a new caracteristica.
	 *
	 * @param CharacteristicPayload $caracteristica
	 * @since 0.1.0
	 * @return self
	 */
	public function add(CharacteristicPayload $caracteristica)
	{
		$this->_fields['caracteristicas'][] = $caracteristica;
		return $this;
	}

	/**
	 * Remove a caracteristica.
	 *
	 * @param CharacteristicPayload $caracteristica
	 * @since 0.1.0
	 * @return self
	 */
	public function remove(CharacteristicPayload $caracteristica)
	{
		$caracteristicas = $this->_fields['caracteristicas'];
		$index = \array_search($caracteristica, $caracteristicas);

		if ($index !== false) {
			unset($caracteristicas[$index]);
		}

		$this->_fields['caracteristicas'] = $caracteristicas;
		return $this;
	}

	/**
	 * Get caracteristicas.
	 *
	 * @since 0.1.0
	 * @return array<CharacteristicPayload>
	 */
	public function caracteristicas(): array
	{
		return $this->_get('caracteristicas');
	}

	/**
	 * Get all fields converting payloads
	 * to an array and removing null values.
	 *
	 * @since 0.1.0
	 * @return array
	 */
	public function toArray(): array
	{
		$caracteristicas = $this->_get('caracteristicas');

		$caracteristicas = \array_map(function ($caracteristica) {
			return $caracteristica->toArray();
		}, $caracteristicas);

		return [
			'caracteristicas' => $caracteristicas
		];
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
			'caracteristicas' => [new Required([])],
		];
	}
}
