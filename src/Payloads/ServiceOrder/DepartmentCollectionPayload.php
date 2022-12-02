<?php

namespace Pgly\Omie\Api\Payloads\ServiceOrder;

use Piggly\ApiClient\Payloads\AbstractPayload;
use Piggly\ApiClient\Payloads\Rules\Required;

/**
 * Department collection payload structure with multiple departments.
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
class DepartmentCollectionPayload extends AbstractPayload
{
	/**
	 * All payload fields.
	 *
	 * @var array
	 * @since 0.1.0
	 */
	protected $_fields = [
		'Departamentos' => []
	];

	/**
	 * Add a new department.
	 *
	 * @param DepartmentPayload $department
	 * @since 0.1.0
	 * @return self
	 */
	public function add(DepartmentPayload $department)
	{
		$this->_fields['Departamentos'][] = $department;
		return $this;
	}

	/**
	 * Remove a department.
	 *
	 * @param DepartmentPayload $department
	 * @since 0.1.0
	 * @return self
	 */
	public function remove(DepartmentPayload $department)
	{
		$departments = $this->_fields['Departamentos'];
		$index = \array_search($department, $departments);

		if ($index !== false) {
			unset($departments[$index]);
		}

		$this->_fields['Departamentos'] = $departments;
		return $this;
	}

	/**
	 * Get departments.
	 *
	 * @since 0.1.0
	 * @return array<DepartmentPayload>
	 */
	public function departments(): array
	{
		return $this->_get('Departamentos');
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
		$departments = $this->departments();

		return \array_map(function ($department) {
			return $department->toArray();
		}, $departments);
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
			'Departamentos' => [new Required([])],
		];
	}
}
