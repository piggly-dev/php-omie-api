<?php

namespace Pgly\Omie\Api\Payloads;

use InvalidArgumentException;
use Pgly\Omie\Api\Utils\Cast;
use Pgly\Omie\Api\Utils\Formatter;
use Piggly\ApiClient\Payloads\AbstractPayload;
use Piggly\ApiClient\Payloads\Rules\MaxLengthRule;
use Piggly\ApiClient\Payloads\Rules\Optional;
use Piggly\ApiClient\Payloads\Rules\Required;
use Piggly\ApiClient\Payloads\Rules\StringRule;

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
class AddressPayload extends AbstractPayload
{
	/**
	 * All payload fields.
	 *
	 * @var array
	 * @since 0.1.0
	 */
	protected $_fields = [
		'endereco' => null,
		'endereco_numero' => null,
		'complemento' => null,
		'bairro' => null,
		'estado' => null,
		'cidade' => null,
		'cep' => null,
		'codigo_pais' => '1058',
		'pesquisar_cep' => 'S'
	];

	/**
	 * Construct object with required fields.
	 *
	 * @param string $cep
	 * @since 0.1.0
	 * @return void
	 */
	public function __construct(
		string $cep
	) {
		$this
			->changeZipcode($cep);
	}

	/**
	 * Change endereco field.
	 *
	 * @param mixed $endereco
	 * @since 0.1.0
	 * @return self
	 */
	public function changeStreet($endereco)
	{
		$this->_fields['endereco'] = Cast::upper($endereco);
		return $this;
	}

	/**
	 * Change endereco_numero field.
	 *
	 * @param mixed $endereco_numero
	 * @since 0.1.0
	 * @return self
	 */
	public function changeNumber($endereco_numero)
	{
		$this->_fields['endereco_numero'] = Cast::upper($endereco_numero);
		return $this;
	}

	/**
	 * Change complemento field.
	 *
	 * @param mixed $complemento
	 * @since 0.1.0
	 * @return self
	 */
	public function changeComplement($complemento)
	{
		$this->_fields['complemento'] = Cast::upper($complemento);
		return $this;
	}

	/**
	 * Change bairro field.
	 *
	 * @param mixed $bairro
	 * @since 0.1.0
	 * @return self
	 */
	public function changeNeighborhood($bairro)
	{
		$this->_fields['bairro'] = Cast::upper($bairro);
		return $this;
	}

	/**
	 * Change estado field.
	 *
	 * @param mixed $estado
	 * @since 0.1.0
	 * @return self
	 */
	public function changeState($estado)
	{
		$this->_fields['estado'] = Cast::upper($estado);
		return $this;
	}

	/**
	 * Change cidade field.
	 *
	 * @param mixed $cidade
	 * @since 0.1.0
	 * @return self
	 */
	public function changeCity($cidade)
	{
		$this->_fields['cidade'] = Cast::upper($cidade);
		return $this;
	}

	/**
	 * Apply city payload to address.
	 * It replaces cidade and estado fields.
	 *
	 * @param mixed $cidade
	 * @since 0.1.0
	 * @return self
	 */
	public function applyCity(CityPayload $city)
	{
		$this->_fields['cidade'] = $city->code();
		$this->_fields['estado'] = $city->state();

		return $this;
	}

	/**
	 * Change cep field.
	 *
	 * @param mixed $cep
	 * @since 0.1.0
	 * @return self
	 */
	public function changeZipcode($cep)
	{
		$this->_fields['cep'] = Formatter::zipcode($cep);
		return $this;
	}

	/**
	 * Get endereco field.
	 *
	 * @since 0.1.0
	 * @return string|null
	 */
	public function street(): ?string
	{
		return $this->_get('endereco');
	}

	/**
	 * Get endereco_numero field.
	 *
	 * @since 0.1.0
	 * @return string|null
	 */
	public function number(): ?string
	{
		return $this->_get('endereco_numero');
	}

	/**
	 * Get complemento field.
	 *
	 * @since 0.1.0
	 * @return string|null
	 */
	public function complement(): ?string
	{
		return $this->_get('complemento');
	}

	/**
	 * Get bairro field.
	 *
	 * @since 0.1.0
	 * @return string|null
	 */
	public function neighborhood(): ?string
	{
		return $this->_get('bairro');
	}

	/**
	 * Get estado field.
	 *
	 * @since 0.1.0
	 * @return string|null
	 */
	public function state(): ?string
	{
		return $this->_get('estado');
	}

	/**
	 * Get cidade field.
	 *
	 * @since 0.1.0
	 * @return string|null
	 */
	public function city(): ?string
	{
		return $this->_get('cidade');
	}

	/**
	 * Get cep field.
	 *
	 * @since 0.1.0
	 * @return string
	 */
	public function zipcode(): string
	{
		return $this->_get('cep');
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
		if (!isset($body['cep'])) {
			throw new InvalidArgumentException('`cep` fields are required.');
		}

		$p = new AddressPayload($body['cep']);

		if (isset($body['endereco'])) {
			$p->changeStreet($body['endereco']);
		}

		if (isset($body['endereco_numero'])) {
			$p->changeNumber($body['endereco_numero']);
		}

		if (isset($body['complemento'])) {
			$p->changeComplement($body['complemento']);
		}

		if (isset($body['bairro'])) {
			$p->changeNeighborhood($body['bairro']);
		}

		if (isset($body['estado'])) {
			$p->changeState($body['estado']);
		}

		if (isset($body['cidade'])) {
			$p->changeCity($body['cidade']);
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
			'endereco' => [new Optional([ new StringRule(), new MaxLengthRule(60) ])],
			'endereco_numero' => [new Optional([ new StringRule(), new MaxLengthRule(10) ])],
			'bairro' => [new Optional([ new StringRule(), new MaxLengthRule(60) ])],
			'complemento' => [new Optional([ new StringRule(), new MaxLengthRule(60) ])],
			'estado' => [new Optional([ new StringRule(), new MaxLengthRule(2) ])],
			'cidade' => [new Optional([ new StringRule(), new MaxLengthRule(40) ])],
			'cep' => [new Required([ new StringRule(), new MaxLengthRule(10) ])],
		];
	}
}
