<?php

namespace Pgly\Omie\Api\Endpoints;

use Exception;
use Monolog\Logger;
use Pgly\Omie\Api\Collections\ListOfPayloadsCollection;
use Pgly\Omie\Api\Payloads\DepartmentPayload;
use Pgly\Omie\Api\Utils\Formatter;
use Piggly\ApiClient\Endpoint;

/**
 * Department endpoint.
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
class DepartmentEndpoint extends Endpoint
{
	/**
	 * List all departments.
	 *
	 * @param string $name
	 * @param int $page
	 * @param int $records
	 * @since 0.1.0
	 * @return ListOfPayloadsCollection|null
	 */
	public function list(int $page = 1, int $records = 50): ?ListOfPayloadsCollection
	{
		try {
			$data = Formatter::requestBody($this->_api->getApp(), 'ListarDepartamentos', [
				'pagina' => $page,
				'registros_por_pagina' => $records,
				'apenas_importado_api' => 'N'
			]);

			$this->_log('find.request', 'POST', \json_encode($data));

			list($body, $code) = $this->_request->post(
				'/geral/departamentos/',
				$data
			)->call();

			if (empty($body['departamentos'])) {
				return [];
			}

			return ListOfPayloadsCollection::create(
				$body['pagina'],
				$body['total_de_paginas'],
				$body['registros'],
				$body['total_de_registros'],
				array_map(function ($city) {
					return DepartmentPayload::import($city);
				}, $body['departamentos'])
			);
		} catch (Exception $e) {
			$this->_log('find.error', $e->getCode(), $e->getMessage(), Logger::ERROR);
			return [];
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
			'omie.api.v1.departments.'.$operation.' ['.$details.'] -> '.$message
		);
	}
}
