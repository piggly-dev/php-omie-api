<?php

namespace Pgly\Omie\Api\Payloads\ServiceOrder;

use InvalidArgumentException;
use Pgly\Omie\Api\Rules\EmailRule;
use Piggly\ApiClient\Payloads\AbstractPayload;
use Piggly\ApiClient\Payloads\Rules\AllowedValuesRule;
use Piggly\ApiClient\Payloads\Rules\Required;
use Piggly\ApiClient\Payloads\Rules\StringRule;

/**
 * Email payload structure.
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
class EmailPayload extends AbstractPayload
{
	/**
	 * All payload fields.
	 *
	 * @var array
	 * @since 0.1.0
	 */
	protected $_fields = [
		'cEnvBoleto' => 'N', /** required */
		'cEnvRecibo' => 'N', /** required */
		'cEnvLink' => 'S', /** required */
		'cEnvViaUnica' => 'N', /** required */
		'cEnviarPara' => null /** required */
	];

	/**
	 * Construct object with required fields.
	 *
	 * @param mixed $cEnviarPara
	 * @since 0.1.0
	 */
	public function __construct($cEnviarPara)
	{
		$this->changeSendTo($cEnviarPara);
	}

	/**
	 * Change cEnvBoleto field.
	 *
	 * @param mixed $code
	 * @since 0.1.0
	 * @return self
	 */
	public function changeSendBillet($code)
	{
		$this->_field['cEnvBoleto'] = \boolval($code) ? 'S' : 'N';
		return $this;
	}

	/**
	 * Change cEnvRecibo field.
	 *
	 * @param mixed $code
	 * @since 0.1.0
	 * @return self
	 */
	public function changeSendReceipt($code)
	{
		$this->_field['cEnvRecibo'] = \boolval($code) ? 'S' : 'N';
		return $this;
	}

	/**
	 * Change cEnvLink field.
	 *
	 * @param mixed $code
	 * @since 0.1.0
	 * @return self
	 */
	public function changeSendLink($code)
	{
		$this->_field['cEnvLink'] = \boolval($code) ? 'S' : 'N';
		return $this;
	}

	/**
	 * Change cEnvViaUnica field.
	 *
	 * @param mixed $code
	 * @since 0.1.0
	 * @return self
	 */
	public function changeSendOnlyOne($code)
	{
		$this->_field['cEnvViaUnica'] = \boolval($code) ? 'S' : 'N';
		return $this;
	}

	/**
	 * Change cEnviarPara field.
	 *
	 * @param mixed $email
	 * @since 0.1.0
	 * @return self
	 */
	public function changeSendTo($email)
	{
		$this->_field['cEnviarPara'] = \strval($email);
		return $this;
	}

	/**
	 * Get cEnvBoleto field.
	 *
	 * @since 0.1.0
	 * @return string
	 */
	public function sendBillet(): string
	{
		return $this->_get('cEnvBoleto');
	}

	/**
	 * Get cEnvRecibo field.
	 *
	 * @since 0.1.0
	 * @return string
	 */
	public function sendReceipt(): string
	{
		return $this->_get('cEnvRecibo');
	}

	/**
	 * Get cEnvLink field.
	 *
	 * @since 0.1.0
	 * @return string
	 */
	public function sendLink(): string
	{
		return $this->_get('cEnvLink');
	}

	/**
	 * Get cEnvViaUnica field.
	 *
	 * @since 0.1.0
	 * @return string
	 */
	public function sendOnlyOne(): string
	{
		return $this->_get('cEnvViaUnica');
	}

	/**
	 * Get cEnviarPara field.
	 *
	 * @since 0.1.0
	 * @return string
	 */
	public function sendTo(): string
	{
		return $this->_get('cEnviarPara');
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
		if (!isset($body['cEnviarPara'])) {
			throw new InvalidArgumentException('`cEnviarPara` fields are required.');
		}

		$p = new EmailPayload($body['cEnviarPara']);
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
			'cEnvBoleto' => [new Required([ new StringRule(), new AllowedValuesRule(['S', 'N']) ])], /** required */
			'cEnvRecibo' => [new Required([ new StringRule(), new AllowedValuesRule(['S', 'N']) ])], /** required */
			'cEnvLink' => [new Required([ new StringRule(), new AllowedValuesRule(['S', 'N']) ])], /** required */
			'cEnvViaUnica' => [new Required([ new StringRule(), new AllowedValuesRule(['S', 'N']) ])], /** required */
			'cEnviarPara' => [new Required([ new StringRule(), new EmailRule() ])], /** required */
		];
	}
}
