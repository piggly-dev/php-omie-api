<?php

namespace Pgly\Omie\Api\Payloads\ServiceOrder;

use DateTimeImmutable;
use InvalidArgumentException;
use Pgly\Omie\Api\Payloads\ClientPayload;
use Pgly\Omie\Api\Utils\Formatter;
use Piggly\ApiClient\Payloads\AbstractPayload;
use Piggly\ApiClient\Payloads\Rules\FloatRule;
use Piggly\ApiClient\Payloads\Rules\InstanceOfRule;
use Piggly\ApiClient\Payloads\Rules\IntegerRule;
use Piggly\ApiClient\Payloads\Rules\MaxLengthRule;
use Piggly\ApiClient\Payloads\Rules\Optional;
use Piggly\ApiClient\Payloads\Rules\Required;
use Piggly\ApiClient\Payloads\Rules\StringRule;

/**
 * Header payload structure with required fields as
 * cCodIntOS, cNumOS, nCodCli, dDtPrevisao, cCodParc,
 * nValorTotal, nQtdeParc and cEtapa.
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
class HeaderPayload extends AbstractPayload
{
	/**
	 * All payload fields.
	 *
	 * @var array
	 * @since 0.1.0
	 */
	protected $_fields = [
		'cCodIntOS' => null, /** required */
		'nCodOS' => null,
		'cNumOS' => null, /** required */
		'cCodIntCli' => null,
		'nCodCli' => null, /** required */
		'dDtPrevisao' => null, /** required */
		'cEtapa' => '10', /** required */
		'nCodVend' => null,
		'nQtdeParc' => 1, /** required */
		'cCodParc' => '999', /** required */
		'nValorTotal' => null, /** required */
		'nValorTotalImpRet' => null,
		'nCodCtr' => null,
	];

	/**
	 * Construct object with required fields.
	 *
	 * @param mixed $integrationCode
	 * @param mixed $osNumber
	 * @param mixed $amount
	 * @since 0.1.0
	 * @return void
	 */
	public function __construct(
		$integrationCode,
		$osNumber,
		$amount
	) {
		$this
			->changeIntegrationCode($integrationCode)
			->changeOSNumber($osNumber)
			->changeTotalAmount($amount);

		$this->changeDate(Formatter::now());
	}

	/**
	 * Associate client to header.
	 *
	 * @param ClientPayload $client
	 * @since 0.1.0
	 * @return self
	 */
	public function associateClient(ClientPayload $client)
	{
		$this->changeClientIntegrationCode($client->integrationCode());
		$this->changeClientCode($client->omieCode());
		return $this;
	}

	/**
	 * Change cCodIntOs field.
	 *
	 * @param mixed $code
	 * @since 0.1.0
	 * @return self
	 */
	public function changeIntegrationCode($code)
	{
		$this->_field['cCodIntOS'] = \strval($code);
		return $this;
	}

	/**
	 * Change nCodOS field.
	 *
	 * @param mixed $code
	 * @since 0.1.0
	 * @return self
	 */
	public function changeOSCode($code)
	{
		$this->_field['nCodOS'] = \intval($code);
		return $this;
	}

	/**
	 * Change cNumOS field.
	 *
	 * @param mixed $code
	 * @since 0.1.0
	 * @return self
	 */
	public function changeOSNumber($code)
	{
		$this->_field['cNumOS'] = \strval($code);
		return $this;
	}

	/**
	 * Change cCodIntCli field.
	 *
	 * @param mixed $code
	 * @since 0.1.0
	 * @return self
	 */
	public function changeClientIntegrationCode($code)
	{
		$this->_field['cCodIntCli'] = \strval($code);
		return $this;
	}

	/**
	 * Change nCodCli field.
	 *
	 * @param mixed $code
	 * @since 0.1.0
	 * @return self
	 */
	public function changeClientCode($code)
	{
		$this->_field['nCodCli'] = \intval($code);
		return $this;
	}

	/**
	 * Change dDtPrevisao field.
	 *
	 * @param mixed $date
	 * @since 0.1.0
	 * @return self
	 */
	public function changeDate($date)
	{
		$this->_field['dDtPrevisao'] = Formatter::date($date);
		return $this;
	}

	/**
	 * Change cEtapa field.
	 *
	 * @param mixed $stage
	 * @since 0.1.0
	 * @return self
	 */
	public function changeStage($stage)
	{
		$this->_field['cEtapa'] = \strval($stage);
		return $this;
	}

	/**
	 * Change nCodVend field.
	 *
	 * @param mixed $code
	 * @since 0.1.0
	 * @return self
	 */
	public function changeSellerCode($code)
	{
		$this->_field['nCodVend'] = \intval($code);
		return $this;
	}

	/**
	 * Change nQtdeParc field.
	 *
	 * @param mixed $code
	 * @since 0.1.0
	 * @return self
	 */
	public function changeInstallments($code)
	{
		$this->_field['nQtdeParc'] = \intval($code);
		return $this;
	}

	/**
	 * Change cCodParc field.
	 *
	 * @param mixed $code
	 * @since 0.1.0
	 * @return self
	 */
	public function changeInstallmentCode($code)
	{
		$this->_field['cCodParc'] = \strval($code);
		return $this;
	}

	/**
	 * Change nValorTotal field.
	 *
	 * @param mixed $value
	 * @since 0.1.0
	 * @return self
	 */
	public function changeTotalAmount($value)
	{
		$this->_field['nValorTotal'] = \floatval($value);
		return $this;
	}

	/**
	 * Change nValorTotalImpRet field.
	 *
	 * @param mixed $value
	 * @since 0.1.0
	 * @return self
	 */
	public function changeTotalAmountWithTax($value)
	{
		$this->_field['nValorTotalImpRet'] = \floatval($value);
		return $this;
	}

	/**
	 * Change nCodCtr field.
	 *
	 * @param mixed $code
	 * @since 0.1.0
	 * @return self
	 */
	public function changeContractCode($code)
	{
		$this->_field['nCodCtr'] = \intval($code);
		return $this;
	}

	/**
	 * Get cCodIntOS field.
	 *
	 * @since 0.1.0
	 * @return string
	 */
	public function integrationCode(): string
	{
		return $this->_get('cCodIntOS');
	}

	/**
	 * Get nCodOS field.
	 *
	 * @since 0.1.0
	 * @return int|null
	 */
	public function osCode(): ?int
	{
		return $this->_get('nCodOS');
	}

	/**
	 * Get cNumOS field.
	 *
	 * @since 0.1.0
	 * @return string
	 */
	public function osNumber(): string
	{
		return $this->_get('cNumOS');
	}

	/**
	 * Get cCodIntCli field.
	 *
	 * @since 0.1.0
	 * @return string|null
	 */
	public function clientIntegrationCode(): ?string
	{
		return $this->_get('cCodIntCli');
	}

	/**
	 * Get nCodCli field.
	 *
	 * @since 0.1.0
	 * @return int|null
	 */
	public function clientCode(): ?int
	{
		return $this->_get('nCodCli');
	}

	/**
	 * Get dDtPrevisao field.
	 *
	 * @since 0.1.0
	 * @return DateTimeImmutable|null
	 */
	public function date(): DateTimeImmutable
	{
		return $this->_get('dDtPrevisao', Formatter::now());
	}

	/**
	 * Get cEtapa field.
	 *
	 * @since 0.1.0
	 * @return string|null
	 */
	public function stage(): ?string
	{
		return $this->_get('cEtapa');
	}

	/**
	 * Get nCodVend field.
	 *
	 * @since 0.1.0
	 * @return int|null
	 */
	public function sellerCode(): ?int
	{
		return $this->_get('nCodVend');
	}

	/**
	 * Get nQtdeParc field.
	 *
	 * @since 0.1.0
	 * @return int|null
	 */
	public function installments(): ?int
	{
		return $this->_get('nQtdeParc');
	}

	/**
	 * Get cCodParc field.
	 *
	 * @since 0.1.0
	 * @return string|null
	 */
	public function installmentCode(): ?string
	{
		return $this->_get('cCodParc');
	}

	/**
	 * Get nValorTotal field.
	 *
	 * @since 0.1.0
	 * @return float
	 */
	public function totalAmount(): float
	{
		return $this->_get('nValorTotal');
	}

	/**
	 * Get nValorTotalImpRet field.
	 *
	 * @since 0.1.0
	 * @return float|null
	 */
	public function totalAmountWithTax(): ?float
	{
		return $this->_get('nValorTotalImpRet');
	}

	/**
	 * Get nCodCtr field.
	 *
	 * @since 0.1.0
	 * @return int|null
	 */
	public function contractCode(): ?int
	{
		return $this->_get('nCodCtr');
	}

	/**
	 * Transform dDtPrevisao to d/m/Y string.
	 *
	 * @since 0.1.0
	 * @return string
	 */
	protected function transform_dDtPrevisao(): string
	{
		return $this->_get('dDtPrevisao')->format('d/m/Y');
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
		if (!isset($body['cCodIntOS'], $body['cNumOS'], $body['nValorTotal'])) {
			throw new InvalidArgumentException('`cCodIntOS`, `cNumOS` and `nValorTotal` fields are required.');
		}

		$p = new HeaderPayload($body['cCodIntOS'], $body['cNumOS'], $body['nValorTotal']);
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
			'cCodIntOS' => [new Required([ new StringRule(), new MaxLengthRule(60) ])], /** required */
			'nCodOS' => [new Optional([ new IntegerRule() ])],
			'cNumOS' => [new Required([ new StringRule(), new MaxLengthRule(15) ])], /** required */
			'cCodIntCli' => [new Optional([ new StringRule() ])],
			'nCodCli' => [new Required([ new IntegerRule() ])], /** required */
			'dDtPrevisao' => [new Required([ new InstanceOfRule(DateTimeImmutable::class) ])], /** required */
			'cEtapa' => [new Required([ new StringRule() ])], /** required */
			'nCodVend' => [new Optional([ new IntegerRule() ])],
			'nQtdeParc' => [new Required([ new IntegerRule() ])], /** required */
			'cCodParc' => [new Required([ new StringRule() ])], /** required */
			'nValorTotal' => [new Required([ new FloatRule() ])], /** required */
			'nValorTotalImpRet' => [new Optional([ new FloatRule() ])],
			'nCodCtr' => [new Optional([ new IntegerRule() ])],
		];
	}
}
