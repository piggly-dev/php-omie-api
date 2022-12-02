<?php

namespace Pgly\Omie\Api\Payloads;

use InvalidArgumentException;
use Pgly\Omie\Api\Rules\CPFOrCNPJRule;
use Pgly\Omie\Api\Utils\Cast;
use Pgly\Omie\Api\Utils\Formatter;
use Piggly\ApiClient\Payloads\AbstractPayload;
use Piggly\ApiClient\Payloads\Rules\MaxLengthRule;
use Piggly\ApiClient\Payloads\Rules\Optional;
use Piggly\ApiClient\Payloads\Rules\Required;
use Piggly\ApiClient\Payloads\Rules\StringRule;

/**
 * Client payload structure with required fields
 * as razao_social, nome_fantasia, contato and
 * optional fields as email and cnpj_cpf.
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
class ClientPayload extends AbstractPayload
{
	/**
	 * All payload fields.
	 *
	 * @var array
	 * @since 0.1.0
	 */
	protected $_fields = [
		'codigo_cliente_omie' => null,
		'codigo_cliente_integracao' => null,
		'razao_social' => null,
		'nome_fantasia' => null,
		'contato' => null,
		'email' => null,
		'cnpj_cpf' => null,
	];

	/**
	 * Address payload.
	 *
	 * @var AddressPayload
	 * @since 0.1.0
	 */
	protected $_address;

	/**
	 * Tag collection payload.
	 *
	 * @var TagCollectionPayload
	 * @since 0.1.0
	 */
	protected $_tags;

	/**
	 * Characteristic collection payload.
	 *
	 * @var CharacteristicCollectionPayload
	 * @since 0.1.0
	 */
	protected $_characteristics;

	/**
	 * Construct object.
	 *
	 * @param mixed $razao_social
	 * @param mixed $nome_fantasia
	 * @param mixed $cnpj_cpf
	 * @param mixed $email
	 * @since 0.1.0
	 * @return void
	 */
	public function __construct(
		$razao_social,
		$nome_fantasia,
		$cnpj_cpf,
		$email
	) {
		$this
			->changeName($razao_social)
			->changeNickname($nome_fantasia)
			->changeDocument($cnpj_cpf)
			->changeEmail($email);

		$this->_tags = new TagCollectionPayload();
		$this->_characteristics = new CharacteristicCollectionPayload();
	}

	/**
	 * Change endereco.
	 *
	 * @param AddressPayload $address
	 * @since 0.1.0
	 * @return self
	 */
	public function changeAddress(AddressPayload $endereco)
	{
		$this->_address = $endereco;
		return $this;
	}

	/**
	 * Change codigo_cliente_integracao field.
	 *
	 * @param mixed $codigo_cliente_integracao
	 * @since 0.1.0
	 * @return self
	 */
	public function changeIntegrationCode($codigo_cliente_integracao)
	{
		$this->_fields['codigo_cliente_integracao'] = \strval($codigo_cliente_integracao);
		return $this;
	}

	/**
	 * Change codigo_cliente_omie field.
	 *
	 * @param mixed $codigo_cliente_omie
	 * @since 0.1.0
	 * @return self
	 */
	public function changeOmieCode($codigo_cliente_omie)
	{
		$this->_fields['codigo_cliente_omie'] = \intval($codigo_cliente_omie);
		return $this;
	}

	/**
	 * Change razao_social field.
	 *
	 * For individual must be the full name.
	 * For company must be the company name.
	 *
	 * @param string $razao_social
	 * @since 0.1.0
	 * @return self
	 */
	public function changeName($razao_social)
	{
		$this->_fields['razao_social'] = Cast::upper($razao_social);
		return $this;
	}

	/**
	 * Change nome_fantasia field.
	 *
	 * For individual must be a nickname.
	 * For company must be a trade name.
	 *
	 * @param string $nome_fantasia
	 * @since 0.1.0
	 * @return self
	 */
	public function changeNickname($nome_fantasia)
	{
		$this->_fields['nome_fantasia'] = Cast::upper($nome_fantasia);
		return $this;
	}

	/**
	 * Change contato field.
	 * For individual or company must be a contact name.
	 *
	 * @param string $contato
	 * @since 0.1.0
	 * @return self
	 */
	public function changeContactName($contato)
	{
		$this->_fields['contato'] = Cast::upper($contato);
		return $this;
	}

	/**
	 * Change email field.
	 *
	 * @param string $email
	 * @since 0.1.0
	 * @return self
	 */
	public function changeEmail($email)
	{
		$this->_fields['email'] = \strval($email);
		return $this;
	}

	/**
	 * Change cnpj_cpf field.
	 *
	 * @param string $cnpj_cpf
	 * @since 0.1.0
	 * @return self
	 */
	public function changeDocument($cnpj_cpf)
	{
		$this->_fields['cnpj_cpf'] = Formatter::cpfOrCnpj($cnpj_cpf);
		return $this;
	}

	/**
	 * Get razao_social field.
	 *
	 * @since 0.1.0
	 * @return string
	 */
	public function name(): string
	{
		return $this->_get('razao_social', '');
	}

	/**
	 * Get nome_fantasia field.
	 *
	 * @since 0.1.0
	 * @return string
	 */
	public function nickname(): string
	{
		return $this->_get('nome_fantasia', '');
	}

	/**
	 * Get contato field.
	 *
	 * @since 0.1.0
	 * @return string|null
	 */
	public function contactName(): ?string
	{
		return $this->_get('contato', '');
	}

	/**
	 * Get email field.
	 *
	 * @since 0.1.0
	 * @return string
	 */
	public function email(): string
	{
		return $this->_get('email', '');
	}

	/**
	 * Get cnpj_cpf field.
	 *
	 * @since 0.1.0
	 * @return string
	 */
	public function document(): string
	{
		return $this->_get('cnpj_cpf', '');
	}

	/**
	 * Get codigo_cliente_integracao field.
	 *
	 * @since 0.1.0
	 * @return string|null
	 */
	public function integrationCode(): ?string
	{
		return $this->_get('codigo_cliente_integracao');
	}

	/**
	 * Get codigo_cliente_omie field.
	 *
	 * @since 0.1.0
	 * @return integer|null
	 */
	public function omieCode(): ?int
	{
		return $this->_get('codigo_cliente_omie');
	}


	/**
	 * Get address payload.
	 *
	 * @since 0.1.0
	 * @return AddressPayload|null
	 */
	public function address(): ?AddressPayload
	{
		return $this->_address;
	}

	/**
	 * Get tags.
	 *
	 * @since 0.1.0
	 * @return CharacteristicCollectionPayload
	 */
	public function tags(): TagCollectionPayload
	{
		return $this->_tags;
	}

	/**
	 * Get caracteristicas.
	 *
	 * @since 0.1.0
	 * @return CharacteristicCollectionPayload
	 */
	public function characteristics(): CharacteristicCollectionPayload
	{
		return $this->_characteristics;
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
		$array = parent::toArray();

		if (!empty($this->_tags->tags())) {
			$array = \array_merge($array, $this->_tags->toArray());
		}

		if (!empty($this->_characteristics->characteristics())) {
			$array = \array_merge($array, $this->_characteristics->toArray());
		}

		if ($this->_address !== null) {
			return \array_merge($array, $this->_address->toArray());
		}

		return $array;
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
		if (!isset($body['razao_social'], $body['nome_fantasia'], $body['cnpj_cpf'], $body['email'])) {
			throw new InvalidArgumentException('`razao_social`, `nome_fantasia` and `cnpj_cpf` fields are required.');
		}

		$p = new ClientPayload($body['razao_social'], $body['nome_fantasia'], $body['cnpj_cpf'], $body['email']);

		if (isset($body['contato'])) {
			$p->changeContactName($body['contato']);
		}

		if (isset($body['codigo_cliente_integracao'])) {
			$p->changeIntegrationCode($body['codigo_cliente_integracao']);
		}

		if (isset($body['codigo_cliente_omie'])) {
			$p->changeOmieCode($body['codigo_cliente_omie']);
		}

		if (isset($body['endereco'])) {
			$p->_address = AddressPayload::import($body);
		}

		if (isset($body['caracteristicas'])) {
			$p->_characteristics = CharacteristicCollectionPayload::import($body);
		}

		if (isset($body['tags'])) {
			$p->_tags = TagCollectionPayload::import($body);
		}

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
			'razao_social' => [new Required([ new StringRule(), new MaxLengthRule(60) ])],
			'cnpj_cpf' => [new Required([ new StringRule(), new MaxLengthRule(20), new CPFOrCNPJRule() ])],
			'nome_fantasia' => [new Required([ new StringRule(), new MaxLengthRule(100) ])],
			'contato' => [new Optional([ new StringRule(), new MaxLengthRule(100) ])],
			'email' => [new Required([ new StringRule() ])],
		];
	}
}
