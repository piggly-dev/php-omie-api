<?php

namespace Pgly\Omie\Api\Endpoints;

use Exception;
use Monolog\Logger;
use Pgly\Omie\Api\Payloads\BankAccountPayload;
use Pgly\Omie\Api\Utils\Formatter;
use Piggly\ApiClient\Endpoint;

/**
 * Bank Account endpoint.
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
class BankAccountEndpoint extends Endpoint
{
	/**
	 * List all bank accounts.
	 *
	 * @param string $name
	 * @param int $page
	 * @param int $records
	 * @since 0.1.0
	 * @return array<BankAccountPayload>
	 */
	public function list(int $page = 1, int $records = 50): array
	{
		try {
			$data = Formatter::requestBody($this->_api->getApp(), 'ListarContasCorrentes', [
				'pagina' => $page,
				'registros_por_pagina' => $records,
			]);

			$this->_log('find.request', 'POST', \json_encode($data));

			list($body, $code) = $this->_request->post(
				'/geral/contacorrente/',
				$data
			)->call();

			if (empty($body['ListarContasCorrentes'])) {
				return [];
			}

			return array_map(function ($i) {
				return BankAccountPayload::import($i);
			}, $body['ListarContasCorrentes']);
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
			'omie.api.v1.bank_accounts.'.$operation.' ['.$details.'] -> '.$message
		);
	}
}
