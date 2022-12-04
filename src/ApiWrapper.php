<?php

namespace Pgly\Omie\Api;

use DateTimeZone;
use Pgly\Omie\Api\Endpoints\BankAccountEndpoint;
use Pgly\Omie\Api\Endpoints\CategoryEndpoint;
use Pgly\Omie\Api\Endpoints\CityEndpoint;
use Pgly\Omie\Api\Endpoints\ClientEndpoint;
use Pgly\Omie\Api\Endpoints\DepartmentEndpoint;
use Pgly\Omie\Api\Endpoints\ServiceEndpoint;
use Pgly\Omie\Api\Endpoints\ServiceOrderEndpoint;
use Piggly\ApiClient\Wrapper;

/**
 * Api Wrapper
 *
 * @package Pgly\Omie\Api
 * @subpackage Pgly\Omie\Api
 * @version 0.1.0
 * @since 0.1.0
 * @category Api
 * @author Caique Araujo <caique@piggly.com.br>
 * @author Piggly Lab <dev@piggly.com.br>
 * @license MIT
 * @copyright 2022 Piggly Lab <dev@piggly.com.br>
 */
class ApiWrapper extends Wrapper
{
	/**
	 * Bank account endpoints.
	 *
	 * @since 0.1.0
	 * @return BankAccountEndpoint
	 */
	public function bankAccount(): BankAccountEndpoint
	{
		return $this->endpoint('bankAccount');
	}

	/**
	 * Category endpoints.
	 *
	 * @since 0.1.0
	 * @return CategoryEndpoint
	 */
	public function category(): CategoryEndpoint
	{
		return $this->endpoint('category');
	}

	/**
	 * City endpoints.
	 *
	 * @since 0.1.0
	 * @return CityEndpoint
	 */
	public function city(): CityEndpoint
	{
		return $this->endpoint('city');
	}

	/**
	 * Client endpoints.
	 *
	 * @since 0.1.0
	 * @return ClientEndpoint
	 */
	public function client(): ClientEndpoint
	{
		return $this->endpoint('client');
	}

	/**
	 * Department endpoints.
	 *
	 * @since 0.1.0
	 * @return DepartmentEndpoint
	 */
	public function department(): DepartmentEndpoint
	{
		return $this->endpoint('department');
	}

	/**
	 * Service endpoints.
	 *
	 * @since 0.1.0
	 * @return ServiceEndpoint
	 */
	public function service(): ServiceEndpoint
	{
		return $this->endpoint('service');
	}

	/**
	 * Service order endpoints.
	 *
	 * @since 0.1.0
	 * @return ServiceOrderEndpoint
	 */
	public function serviceOrder(): ServiceOrderEndpoint
	{
		return $this->endpoint('serviceOrder');
	}

	/**
	 * Get all endpoint classes name.
	 *
	 * @since 0.1.0
	 * @return array
	 */
	public static function endpointClasses(): array
	{
		return [
			'bankAccount' => BankAccountEndpoint::class,
			'category' => CategoryEndpoint::class,
			'city' => CityEndpoint::class,
			'client' => ClientEndpoint::class,
			'department' => DepartmentEndpoint::class,
			'service' => ServiceEndpoint::class,
			'serviceOrder' => ServiceOrderEndpoint::class,
		];
	}

	/**
	 * Get timezone.
	 *
	 * @since 0.1.0
	 * @return DateTimeZone
	 */
	public static function getTimezone(): DateTimeZone
	{
		return static::$_timezone;
	}
}
