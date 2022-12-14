<?php

namespace Pgly\Omie\Api\Endpoints;

use Exception;
use Monolog\Logger;
use Pgly\Omie\Api\Collections\ListOfPayloadsCollection;
use Pgly\Omie\Api\Payloads\CityPayload;
use Pgly\Omie\Api\Utils\Formatter;
use Piggly\ApiClient\Endpoint;

/**
 * City endpoint.
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
class CityEndpoint extends Endpoint
{
	/**
	 * Try to find a city by its exact name.
	 *
	 * @param string $name
	 * @since 0.1.0
	 * @return CityPayload|null
	 */
	public function findByExactName(string $name): ?CityPayload
	{
		try {
			$data = Formatter::requestBody($this->_api->getApp(), 'PesquisarCidades', [
				'pagina' => 1,
				'registros_por_pagina' => 1,
				'filtrar_cidade_contendo' => $name
			]);

			$this->_log('findByExactName.request', 'POST', \json_encode($data));

			list($body, $code) = $this->_request->post(
				'/geral/cidades/',
				$data
			)->call();

			if (empty($body['lista_cidades'])) {
				return null;
			}

			$name = \strtolower($name);

			foreach ($body['lista_cidades'] as $city) {
				if (\strtolower($city['cNome']) !== $name) {
					continue;
				}

				return CityPayload::import($city);
			}

			return null;
		} catch (Exception $e) {
			$this->_log('findByExactName.error', $e->getCode(), $e->getMessage(), Logger::ERROR);
			return null;
		}
	}

	/**
	 * Try to find a city by its name.
	 *
	 * @param string $name
	 * @param int $page
	 * @param int $records
	 * @since 0.1.0
	 * @return ListOfPayloadsCollection|null
	 */
	public function findByName(string $name, int $page = 1, int $records = 50): ?ListOfPayloadsCollection
	{
		try {
			$data = Formatter::requestBody($this->_api->getApp(), 'PesquisarCidades', [
				'pagina' => $page,
				'registros_por_pagina' => $records,
				'filtrar_cidade_contendo' => $name
			]);

			$this->_log('findByName.request', 'POST', \json_encode($data));

			list($body, $code) = $this->_request->post(
				'/geral/cidades/',
				$data
			)->call();

			if (empty($body['lista_cidades'])) {
				return [];
			}

			return ListOfPayloadsCollection::create(
				$body['pagina'],
				$body['total_de_paginas'],
				$body['registros'],
				$body['total_de_registros'],
				array_map(function ($city) {
					return CityPayload::import($city);
				}, $body['lista_cidades'])
			);
		} catch (Exception $e) {
			$this->_log('findByName.error', $e->getCode(), $e->getMessage(), Logger::ERROR);
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
			'omie.api.v1.city.'.$operation.' ['.$details.'] -> '.$message
		);
	}
}
