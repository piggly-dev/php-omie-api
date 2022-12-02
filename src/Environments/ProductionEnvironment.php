<?php

namespace Pgly\Omie\Api\Environments;

use Piggly\ApiClient\Configuration;
use Piggly\ApiClient\Environments\AbstractEnvironment;
use Piggly\ApiClient\Models\ApplicationModel;
use Piggly\ApiClient\Models\CredentialModel;
use Piggly\ApiClient\Payloads\AbstractPayload;
use Piggly\ApiClient\Request;
use RuntimeException;

/**
 * Production Environment mutator.
 *
 * @package Pgly\Omie\Api
 * @subpackage Pgly\Omie\Api\Environments
 * @version 0.1.0
 * @since 0.1.0
 * @category Payloads
 * @author Caique Araujo <caique@piggly.com.br>
 * @author Piggly Lab <dev@piggly.com.br>
 * @license MIT
 * @copyright 2022 Piggly Lab <dev@piggly.com.br>
 */
class ProductionEnvironment extends AbstractEnvironment
{
	/**
	 * Base URL.
	 *
	 * @var string
	 * @since 0.1.0
	 */
	protected $_url = 'https://app.omie.com.br/api/v1';

	/**
	 * Do an OAuth connection to get the access token.
	 * Must fill application model with credential returned
	 * and return the credential model created.
	 *
	 * @param Configuration $client
	 * @param ApplicationModel $app
	 * @since 0.1.0
	 * @return CredentialModel
	 * @throws RuntimeException
	 */
	public function token(Configuration $client, $app): CredentialModel
	{
		throw new RuntimeException('Application key e application secret are permanent key, must not be set by API.');
	}

	/**
	 * Prepare request authenticated requests, filling its headers,
	 * access token, setting host, and anything else.
	 * Must return request created.
	 *
	 * @param Configuration $client
	 * @param ApplicationModel $app
	 * @since 1.0.11
	 * @return Request
	 */
	public function prepare(Configuration $client, $app): Request
	{
		// Must clone to keep original setup
		$_client = $client->clone();

		// Ensure host is as expected
		$_client->host($this->_url);

		// Create a request
		$request  = new Request($_client);

		$request->applyHeaders([
			'Content-Type' => 'application/json; charset=utf-8',
		]);

		return $request;
	}
}
