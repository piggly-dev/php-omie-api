<?php

namespace Pgly\Omie\Api\Endpoints;

use Exception;
use Monolog\Logger;
use Pgly\Omie\Api\Payloads\ServicePayload;
use Pgly\Omie\Api\Utils\Formatter;
use Piggly\ApiClient\Endpoint;

/**
 * Service endpoint.
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
class ServiceEndpoint extends Endpoint
{
	/**
	 * Try to find a service by its description.
	 *
	 * @param string $name
	 * @param int $page
	 * @param int $records
	 * @since 0.1.0
	 * @return array<ServicePayload>
	 */
	public function findByDescription(string $service, int $page = 1, int $records = 50): array
	{
		try {
			$data = Formatter::requestBody($this->_api->getApp(), 'ListarCadastroServico', [
				'nPagina' => $page,
				'nRegPorPagina' => $records,
				'cDescricao' => $service
			]);

			$this->_log('findByDescription.request', 'POST', \json_encode($data));

			list($body, $code) = $this->_request->post(
				'/servicos/servico/',
				$data
			)->call();

			if (empty($body['cadastros'])) {
				return null;
			}

			return array_map(function ($s) {
				return ServicePayload::import($s);
			}, $body['cadastros']);
		} catch (Exception $e) {
			$this->_log('findByDescription.error', $e->getCode(), $e->getMessage(), Logger::ERROR);
			return null;
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
			'omie.api.v1.services.'.$operation.' ['.$details.'] -> '.$message
		);
	}
}
