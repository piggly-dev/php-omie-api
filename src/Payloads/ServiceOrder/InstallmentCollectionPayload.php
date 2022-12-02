<?php

namespace Pgly\Omie\Api\Payloads\ServiceOrder;

use Piggly\ApiClient\Payloads\AbstractPayload;
use Piggly\ApiClient\Payloads\Rules\Required;

/**
 * Installment collection payload structure with multiple installments.
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
class InstallmentCollectionPayload extends AbstractPayload
{
	/**
	 * All payload fields.
	 *
	 * @var array
	 * @since 0.1.0
	 */
	protected $_fields = [
		'Parcelas' => []
	];

	/**
	 * Add a new installment.
	 *
	 * @param InstallmentPayload $installment
	 * @since 0.1.0
	 * @return self
	 */
	public function add(InstallmentPayload $installment)
	{
		$this->_fields['Parcelas'][] = $installment;
		return $this;
	}

	/**
	 * Remove a installment.
	 *
	 * @param InstallmentPayload $installment
	 * @since 0.1.0
	 * @return self
	 */
	public function remove(InstallmentPayload $installment)
	{
		$installments = $this->_fields['Parcelas'];
		$index = \array_search($installment, $installments);

		if ($index !== false) {
			unset($installments[$index]);
		}

		$this->_fields['Parcelas'] = $installments;
		return $this;
	}

	/**
	 * Get installments.
	 *
	 * @since 0.1.0
	 * @return array<InstallmentPayload>
	 */
	public function installments(): array
	{
		return $this->_get('Parcelas');
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
		$installments = $this->installments();

		return \array_map(function ($installment) {
			return $installment->toArray();
		}, $installments);
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
			'Parcelas' => [new Required([])],
		];
	}
}
