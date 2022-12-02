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
	 * Add a new characteristic.
	 *
	 * @param CharacteristicPayload $characteristic
	 * @since 0.1.0
	 * @return self
	 */
	public function add(CharacteristicPayload $characteristic)
	{
		$this->_fields['caracteristicas'][] = $characteristic;
		return $this;
	}

	/**
	 * Remove a characteristic.
	 *
	 * @param CharacteristicPayload $characteristic
	 * @since 0.1.0
	 * @return self
	 */
	public function remove(CharacteristicPayload $characteristic)
	{
		$characteristics = $this->_fields['caracteristicas'];
		$index = \array_search($characteristic, $characteristics);

		if ($index !== false) {
			unset($characteristics[$index]);
		}

		$this->_fields['caracteristicas'] = $characteristics;
		return $this;
	}

	/**
	 * Get characteristics.
	 *
	 * @since 0.1.0
	 * @return array<CharacteristicPayload>
	 */
	public function characteristics(): array
	{
		return $this->_get('caracteristicas');
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
		$p = new CharacteristicCollectionPayload();

		$p->_fields['caracteristicas'] = \array_map(function ($c) {
			return CharacteristicPayload::import($c);
		}, $body['caracteristicas'] ?? []);

		return $p;
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
		$characteristics = $this->_get('caracteristicas');

		$characteristics = \array_map(function ($characteristic) {
			return $characteristic->toArray();
		}, $characteristics);

		return [
			'caracteristicas' => $characteristics
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
