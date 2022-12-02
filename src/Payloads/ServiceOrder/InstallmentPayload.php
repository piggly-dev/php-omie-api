<?php

namespace Pgly\Omie\Api\Payloads\ServiceOrder;

use DateTimeImmutable;
use InvalidArgumentException;
use Pgly\Omie\Api\Utils\Formatter;
use Piggly\ApiClient\Payloads\AbstractPayload;
use Piggly\ApiClient\Payloads\Rules\AllowedValuesRule;
use Piggly\ApiClient\Payloads\Rules\FloatRule;
use Piggly\ApiClient\Payloads\Rules\InstanceOfRule;
use Piggly\ApiClient\Payloads\Rules\IntegerRule;
use Piggly\ApiClient\Payloads\Rules\Required;
use Piggly\ApiClient\Payloads\Rules\StringRule;

/**
 * Installment payload structure.
 *
 * @package Pgly\Omie\Api
 * @subpackage Pgly\Omie\Api\Payloads\ServiceOrder
 * @version 0.1.0
 * @since 0.1.0
 * @category Payloads
 * @author Caique Araujo <caique@piggly.com.br>
 * @author Piggly Lab <dev@piggly.com.br>
 * @license MIT
 * @copyright 2022 Piggly Lab <dev@piggly.com.br>
 */
class InstallmentPayload extends AbstractPayload
{
	/**
	 * All payload fields.
	 *
	 * @var array
	 * @since 0.1.0
	 */
	protected $_fields = [
		'nParcela' => null, /** required */
		'dDtVenc' => null, /** required */
		'nValor' => null, /** required */
		'nPercentual' => null, /** required */
		'nao_gerar_boleto' => 'S', /** required */
	];

	/**
	 * Construct object with required fields.
	 *
	 * @param mixed $nParcela
	 * @param mixed $dDtVenc
	 * @param mixed $nValor
	 * @param mixed $nPercentual
	 * @since 0.1.0
	 */
	public function __construct($nParcela, $dDtVenc, $nValor, $nPercentual)
	{
		$this->changeNumber($nParcela)
			->changeDueDate($dDtVenc)
			->changeAmount($nValor)
			->changePercentage($nPercentual);
	}

	/**
	 * Change nParcela field.
	 *
	 * @param int $number
	 * @return self
	 * @since 0.1.0
	 */
	public function changeNumber(int $number)
	{
		$this->_field['nParcela'] = $number;
		return $this;
	}

	/**
	 * Change dDtVenc field.
	 *
	 * @param string $date
	 * @return self
	 * @since 0.1.0
	 */
	public function changeDueDate($date)
	{
		$this->_field['dDtVenc'] = Formatter::date($date);
		return $this;
	}

	/**
	 * Change nValor field.
	 *
	 * @param float $amount
	 * @return self
	 * @since 0.1.0
	 */
	public function changeAmount(float $amount)
	{
		$this->_field['nValor'] = \floatval($amount);
		return $this;
	}

	/**
	 * Change nPercentual field.
	 *
	 * @param int $percentage
	 * @return self
	 * @since 0.1.0
	 */
	public function changePercentage(int $percentage)
	{
		$this->_field['nPercentual'] = \intval($percentage);
		return $this;
	}

	/**
	 * Change nao_gerar_boleto field.
	 *
	 * @param bool $generate
	 * @return self
	 * @since 0.1.0
	 */
	public function changeNotGenerateBillet(bool $generate)
	{
		$this->_field['nao_gerar_boleto'] = $generate ? 'S' : 'N';
		return $this;
	}

	/**
	 * Get nParcela field.
	 *
	 * @since 0.1.0
	 * @return int
	 */
	public function number(): int
	{
		return $this->_get('nParcela');
	}

	/**
	 * Get dDtVenc field.
	 *
	 * @since 0.1.0
	 * @return DateTimeImmutable
	 */
	public function dueDate(): DateTimeImmutable
	{
		return $this->_get('dDtVenc', Formatter::now());
	}

	/**
	 * Get nValor field.
	 *
	 * @since 0.1.0
	 * @return float
	 */
	public function amount(): float
	{
		return $this->_get('nValor');
	}

	/**
	 * Get nPercentual field.
	 *
	 * @since 0.1.0
	 * @return int
	 */
	public function percentage(): int
	{
		return $this->_get('nPercentual');
	}

	/**
	 * Get nao_gerar_boleto field.
	 *
	 * @since 0.1.0
	 * @return string
	 */
	public function notGenerateBillet(): string
	{
		return $this->_get('nao_gerar_boleto');
	}

	/**
	 * Transform dDtVenc to d/m/Y string.
	 *
	 * @since 0.1.0
	 * @return string
	 */
	protected function transform_dDtVenc(): string
	{
		return $this->_get('dDtVenc')->format('d/m/Y');
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
		if (!isset($body['nParcela'], $body['dDtVenc'], $body['nValor'], $body['nPercentual'])) {
			throw new InvalidArgumentException('`nParcela`, `dDtVenc`, `nValor` and `nPercentual` fields are required.');
		}

		$p = new InstallmentPayload($body['nParcela'], $body['dDtVenc'], $body['nValor'], $body['nPercentual']);
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
			'nParcela' => [new Required([ new IntegerRule() ])], /** required */
			'dDtVenc' => [new Required([ new InstanceOfRule(DateTimeImmutable::class) ])], /** required */
			'nValor' => [new Required([ new FloatRule() ])], /** required */
			'nPercentual' => [new Required([ new IntegerRule() ])], /** required */
			'nao_gerar_boleto' => [new Required([ new StringRule(), new AllowedValuesRule(['S', 'N']) ])], /** required */
		];
	}
}
