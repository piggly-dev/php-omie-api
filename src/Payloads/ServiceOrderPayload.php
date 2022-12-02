<?php

namespace Pgly\Omie\Api\Payloads;

use InvalidArgumentException;
use Pgly\Omie\Api\Payloads\ServiceOrder\AdditionalDataPayload;
use Pgly\Omie\Api\Payloads\ServiceOrder\DepartmentCollectionPayload;
use Pgly\Omie\Api\Payloads\ServiceOrder\EmailPayload;
use Pgly\Omie\Api\Payloads\ServiceOrder\HeaderPayload;
use Pgly\Omie\Api\Payloads\ServiceOrder\InstallmentCollectionPayload;
use Pgly\Omie\Api\Payloads\ServiceOrder\ServiceCollectionPayload;
use Piggly\ApiClient\Payloads\AbstractPayload;
use Piggly\ApiClient\Payloads\Rules\InstanceOfRule;
use Piggly\ApiClient\Payloads\Rules\Optional;
use Piggly\ApiClient\Payloads\Rules\Required;

/**
 * Address payload structure with required fields as
 * cep and optional fields as endereco, endereco_numero,
 * complemento, bairro, estado and cidade.
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
class ServiceOrderPayload extends AbstractPayload
{
	/**
	 * All payload fields.
	 *
	 * @var array
	 * @since 0.1.0
	 */
	protected $_fields = [
		'Cabecalho' => null, /** required */
		'Departamentos' => null,
		'Email' => null, /** required */
		'InformacoesAdicionais' => null, /** required */
		'Parcelas' => null,
		'ServicosPrestados' => null, /** required */
	];

	/**
	 * Construct object with required fields.
	 *
	 * @param HeaderPayload $Cabecalho
	 * @param EmailPayload $Email
	 * @param AdditionalDataPayload $InformacoesAdicionais
	 * @param ServiceCollectionPayload $ServicosPrestados
	 * @since 0.1.0
	 */
	public function __construct(HeaderPayload $Cabecalho, EmailPayload $Email, AdditionalDataPayload $InformacoesAdicionais, ServiceCollectionPayload $ServicosPrestados)
	{
		$this
			->associateHeader($Cabecalho)
			->associateEmail($Email)
			->associateAdditionalData($InformacoesAdicionais)
			->associateServices($ServicosPrestados);
	}

	/**
	 * Associate header.
	 *
	 * @param HeaderPayload $payload
	 * @since 0.1.0
	 * @return self
	 */
	public function associateHeader(HeaderPayload $payload)
	{
		$this->_fields['Cabecalho'] = $payload;
		return $this;
	}

	/**
	 * Associate departments.
	 *
	 * @param DepartmentCollectionPayload $payload
	 * @since 0.1.0
	 * @return self
	 */
	public function associateDepartments(DepartmentCollectionPayload $payload)
	{
		$this->_fields['Departamentos'] = $payload;
		return $this;
	}

	/**
	 * Associate email.
	 *
	 * @param EmailPayload $payload
	 * @since 0.1.0
	 * @return self
	 */
	public function associateEmail(EmailPayload $payload)
	{
		$this->_fields['Email'] = $payload;
		return $this;
	}

	/**
	 * Associate additional data.
	 *
	 * @param AdditionalDataPayload $payload
	 * @since 0.1.0
	 * @return self
	 */
	public function associateAdditionalData(AdditionalDataPayload $payload)
	{
		$this->_fields['InformacoesAdicionais'] = $payload;
		return $this;
	}

	/**
	 * Associate installments.
	 *
	 * @param InstallmentCollectionPayload $payload
	 * @since 0.1.0
	 * @return self
	 */
	public function associateInstallments(InstallmentCollectionPayload $payload)
	{
		$this->_fields['Parcelas'] = $payload;
		return $this;
	}

	/**
	 * Associate services.
	 *
	 * @param ServiceCollectionPayload $payload
	 * @since 0.1.0
	 * @return self
	 */
	public function associateServices(ServiceCollectionPayload $payload)
	{
		$this->_fields['ServicosPrestados'] = $payload;
		return $this;
	}

	/**
	 * Get header.
	 *
	 * @since 0.1.0
	 * @return HeaderPayload|null
	 */
	public function header(): ?HeaderPayload
	{
		return $this->_get('Cabecalho');
	}

	/**
	 * Get departments.
	 *
	 * @since 0.1.0
	 * @return DepartmentCollectionPayload|null
	 */
	public function departments(): ?DepartmentCollectionPayload
	{
		return $this->_get('Departamentos');
	}

	/**
	 * Get email.
	 *
	 * @since 0.1.0
	 * @return EmailPayload|null
	 */
	public function email(): ?EmailPayload
	{
		return $this->_get('Email');
	}

	/**
	 * Get additional data.
	 *
	 * @since 0.1.0
	 * @return AdditionalDataPayload|null
	 */
	public function additionalData(): ?AdditionalDataPayload
	{
		return $this->_get('InformacoesAdicionais');
	}

	/**
	 * Get installments.
	 *
	 * @since 0.1.0
	 * @return array|null
	 */
	public function installments(): ?array
	{
		return $this->_get('Parcelas');
	}

	/**
	 * Get services.
	 *
	 * @since 0.1.0
	 * @return array|null
	 */
	public function services(): ?array
	{
		return $this->_get('ServicosPrestados');
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
		if (!isset($body['Cabecalho'], $body['Email'], $body['InformacoesAdicionais'], $body['ServicosPrestados'])) {
			throw new InvalidArgumentException('`Cabecalho`, `Email`, `InformacoesAdicionais` and `ServicosPrestados` fields are required.');
		}

		$header = HeaderPayload::import($body['Cabecalho']);
		$email = EmailPayload::import($body['Email']);
		$additionalData = AdditionalDataPayload::import($body['InformacoesAdicionais']);
		$services = ServiceCollectionPayload::import($body['ServicosPrestados']);

		$p = new ServiceOrderPayload($header, $email, $additionalData, $services);
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
			'Cabecalho' => [new Required([ new InstanceOfRule(HeaderPayload::class) ])], /** required */
			'Departamentos' => [new Optional([ new InstanceOfRule(DepartmentCollectionPayload::class) ])],
			'Email' => [new Required([ new InstanceOfRule(EmailPayload::class) ])], /** required */
			'InformacoesAdicionais' => [new Required([ new InstanceOfRule(AdditionalDataPayload::class) ])], /** required */
			'Parcelas' => [new Optional([ new InstanceOfRule(InstallmentCollectionPayload::class) ])],
			'ServicosPrestados' => [new Required([ new InstanceOfRule(ServiceCollectionPayload::class) ])], /** required */
		];
	}
}
