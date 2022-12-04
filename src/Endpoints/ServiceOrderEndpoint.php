<?php

namespace Pgly\Omie\Api\Endpoints;

use Exception;
use InvalidArgumentException;
use Monolog\Logger;
use Pgly\Omie\Api\Payloads\ServiceOrderPayload;
use Pgly\Omie\Api\Utils\Formatter;
use Piggly\ApiClient\Endpoint;
use Piggly\ApiClient\Exceptions\ApiResponseException;

/**
 * ServiceOrder endpoint.
 *
 * @package Pgly\Omie\Api
 * @subpackage Pgly\Omie\Api\Endpoints
 * @version 0.1.0
 * @since 0.1.0
 * @category Payloads
 * @author Caique Araujo <caique@piggly.com.br>
 * @author Piggly Lab <dev@piggly.com.br>
 * @license MIT
 * @copyright 2022 Piggly Lab <dev@piggly.com.br>
 */
class ServiceOrderEndpoint extends Endpoint
{
	/**
	 * Create a new service order.
	 *
	 * @param ServiceOrderPayload $payload
	 * @since 0.1.0
	 * @return ServiceOrderPayload
	 * @throws InvalidArgumentException
	 * @throws ApiResponseException
	 * @throws Exception
	 */
	public function create(ServiceOrderPayload $payload): ServiceOrderPayload
	{
		// Assert payload without throw an expection
		$payload->assert();

		try {
			$data = Formatter::requestBody($this->_api->getApp(), 'IncluirOS', $payload);
			$this->_log('create.request', 'POST', \json_encode($data));

			list($body, $code) = $this->_request->post(
				'/servicos/os/',
				$data
			)->call();

			if (!isset($data['cCodIntOS'])) {
				throw new ApiResponseException($body['cDescStatus'] ?? $body['faultstring'] ?? 'A ordem de serviço não pode ser criada');
			}

			$payload->header()->changeOSCode($data['cCodIntOS']);
			return $payload;
		} catch (Exception $e) {
			$this->_log('create.error', $e->getCode(), $e->getMessage(), Logger::ERROR);

			if ($e instanceof ApiResponseException) {
				if (isset($e->getResponseBody()['faultstring'])) {
					throw new Exception($e->getResponseBody()['faultstring']);
				}
			}

			throw $e;
		}
	}

	/**
	 * Check if service order payload exists by integration code.
	 *
	 * @param string $code
	 * @since 0.1.0
	 * @return boolean
	 */
	public function existsByIntegrationCode(string $code): bool
	{
		return $this->_exists('existsByIntegrationCode', ['cCodIntOS' => $code]);
	}

	/**
	 * Check if service order payload exists by code.
	 *
	 * @param int $code
	 * @since 0.1.0
	 * @return boolean
	 */
	public function existsByCode(int $code): bool
	{
		return $this->_exists('existsByCode', ['nCodOS' => $code]);
	}

	/**
	 * Check if service order payload exists by number.
	 *
	 * @param string $code
	 * @since 0.1.0
	 * @return boolean
	 */
	public function existsByNumber(string $code): bool
	{
		return $this->_exists('existsByNumber', ['cNumOS' => $code]);
	}

	/**
	 * Check if service order payload exists.
	 *
	 * @param string $method
	 * @since 0.1.0
	 * @return boolean
	 */
	protected function _exists(string $method, array $filter): bool
	{
		try {
			$data = Formatter::requestBody($this->_api->getApp(), 'ConsultarOS', $filter);

			$this->_log($method.'.request', 'POST', \json_encode($data));

			list($body, $code) = $this->_request->post(
				'/servicos/os/',
				$data
			)->call();

			return !empty($body['ServicosPrestados']);
		} catch (Exception $e) {
			$this->_log($method.'.error', $e->getCode(), $e->getMessage(), Logger::ERROR);
			return false;
		}
	}

	/**
	 * Do a log.
	 *
	 * @param string $operation
	 * @param string $details
	 * @param string $message
	 * @param int $level
	 * @since 0.1.0
	 * @return void
	 */
	protected function _log(string $operation, string $details, string $message, int $level = 100)
	{
		$this->_request->getConfig()->log(
			$level,
			'omie.api.v1.service_order.'.$operation.' ['.$details.'] -> '.$message
		);
	}
}
