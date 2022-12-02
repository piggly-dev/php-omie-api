<?php

namespace Pgly\Omie\Api\Payloads\ServiceOrder;

use Piggly\ApiClient\Payloads\AbstractPayload;
use Piggly\ApiClient\Payloads\Rules\Required;

/**
 * Service collection payload structure with multiple services.
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
class ServiceCollectionPayload extends AbstractPayload
{
	/**
	 * All payload fields.
	 *
	 * @var array
	 * @since 0.1.0
	 */
	protected $_fields = [
		'ServicosPrestados' => []
	];

	/**
	 * Add a new service.
	 *
	 * @param ServicePayload $service
	 * @since 0.1.0
	 * @return self
	 */
	public function add(ServicePayload $service)
	{
		$this->_fields['ServicosPrestados'][] = $service;
		return $this;
	}

	/**
	 * Remove a service.
	 *
	 * @param ServicePayload $service
	 * @since 0.1.0
	 * @return self
	 */
	public function remove(ServicePayload $service)
	{
		$services = $this->_fields['ServicosPrestados'];
		$index = \array_search($service, $services);

		if ($index !== false) {
			unset($services[$index]);
		}

		$this->_fields['ServicosPrestados'] = $services;
		return $this;
	}

	/**
	 * Get services.
	 *
	 * @since 0.1.0
	 * @return array<ServicePayload>
	 */
	public function services(): array
	{
		return $this->_get('ServicosPrestados');
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
		$services = $this->services();

		return \array_map(function ($service) {
			return $service->toArray();
		}, $services);
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
			'ServicosPrestados' => [new Required([])],
		];
	}
}
