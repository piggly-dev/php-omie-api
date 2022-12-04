<?php

namespace Pgly\Omie\Api\Endpoints;

use Exception;
use InvalidArgumentException;
use Monolog\Logger;
use Pgly\Omie\Api\Payloads\ClientPayload;
use Pgly\Omie\Api\Utils\Formatter;
use Piggly\ApiClient\Endpoint;
use Piggly\ApiClient\Exceptions\ApiResponseException;

/**
 * Client endpoint.
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
class ClientEndpoint extends Endpoint
{
	/**
	 * Create or update client.
	 *
	 * @param ClientPayload $payload
	 * @since 0.1.0
	 * @return ClientPayload
	 * @throws InvalidArgumentException
	 * @throws ApiResponseException
	 * @throws Exception
	 */
	public function createOrUpdate(ClientPayload $payload): ClientPayload
	{
		if (!empty($payload->omieCode())) {
			return $this->update($payload);
		}

		$found = $this->findByDocument($payload->document());

		if ($found) {
			$payload->changeOmieCode($found->omieCode());
			return $this->update($payload);
		}

		return $this->create($payload);
	}

	/**
	 * Create a new client profile.
	 *
	 * @param ClientPayload $payload
	 * @since 0.1.0
	 * @return ClientPayload
	 * @throws InvalidArgumentException
	 * @throws ApiResponseException
	 * @throws Exception
	 */
	public function create(ClientPayload $payload): ClientPayload
	{
		// Assert payload without throw an expection
		$payload->assert();

		try {
			$data = Formatter::requestBody($this->_api->getApp(), 'IncluirCliente', $payload);
			$this->_log('create.request', 'POST', \json_encode($data));

			list($body, $code) = $this->_request->post(
				'/geral/clientes/',
				$data
			)->call();

			if (!isset($data['codigo_cliente_omie'])) {
				throw new ApiResponseException($body['descricao_status'] ?? $body['faultstring'] ?? 'O cliente não pode ser criado');
			}

			$payload->changeOmieCode($data['codigo_cliente_omie']);
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
	 * Update a client profile.
	 *
	 * @param ClientPayload $payload
	 * @since 0.1.0
	 * @return ClientPayload
	 * @throws InvalidArgumentException
	 * @throws ApiResponseException
	 * @throws Exception
	 */
	public function update(ClientPayload $payload): ClientPayload
	{
		// Assert payload without throw an expection
		$payload->assert();

		if (\is_null($payload->omieCode())) {
			throw new InvalidArgumentException('O código do cliente é obrigatório');
		}

		try {
			$data = Formatter::requestBody($this->_api->getApp(), 'AlterarCliente', $payload);
			$this->_log('update.request', 'POST', \json_encode($data));

			list($body, $code) = $this->_request->post(
				'/geral/clientes/',
				$data
			)->call();

			if (!isset($data['codigo_cliente_omie'])) {
				throw new ApiResponseException($body['descricao_status'] ?? $body['faultstring'] ?? 'O cliente não pode ser criado');
			}

			$payload->changeOmieCode($data['codigo_cliente_omie']);
			return $payload;
		} catch (Exception $e) {
			$this->_log('update.error', $e->getCode(), $e->getMessage(), Logger::ERROR);

			if ($e instanceof ApiResponseException) {
				if (isset($e->getResponseBody()['faultstring'])) {
					throw new Exception($e->getResponseBody()['faultstring']);
				}
			}

			throw $e;
		}
	}

	/**
	 * Find client payload by document.
	 *
	 * @param string $document
	 * @since 0.1.0
	 * @return ClientPayload|null
	 */
	public function findByDocument(string $document): ?ClientPayload
	{
		try {
			$data = Formatter::requestBody($this->_api->getApp(), 'ListarClientes', [
				'pagina' => 1,
				'registros_por_pagina' => 1,
				'clientesFiltro' => [
					'cnpj_cpf' => $document
				]
			]);

			$this->_log('findByDocument.request', 'POST', \json_encode($data));

			list($body, $code) = $this->_request->post(
				'/geral/clientes/',
				$data
			)->call();

			if (empty($body['clientes_cadastro'])) {
				return null;
			}

			return ClientPayload::import($data['clientes_cadastro'][0]);
		} catch (Exception $e) {
			$this->_log('findByDocument.error', $e->getCode(), $e->getMessage(), Logger::ERROR);
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
			'omie.api.v1.client.'.$operation.' ['.$details.'] -> '.$message
		);
	}
}
