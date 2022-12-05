<?php

namespace Pgly\Tests\Omie\Api\Payloads;

use Pgly\Omie\Api\ApiWrapper;
use Pgly\Omie\Api\Models\ApplicationModel;
use Pgly\Omie\Api\Payloads\DepartmentPayload;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \Pgly\Omie\Api\Endpoints\DepartmentEndpoint
 */
class DepartmentEndpointTest extends TestCase
{
	/**
	 * Api Wrapper.
	 *
	 * @var ApiWrapper
	 */
	protected $_api;

	/**
	 * Setup.
	 *
	 * @return void
	 */
	public function setUp(): void
	{
		$dotenv = \Dotenv\Dotenv::createImmutable(__DIR__.'/../../');
		$dotenv->load();

		$app = new ApplicationModel();

		$app->set('client_id', $_ENV['CLIENT_ID']);
		$app->set('client_secret', $_ENV['CLIENT_SK']);

		$this->_api = new ApiWrapper($app);
	}

	/**
	 * @test Test if can list data.
	 * @return void
	 */
	public function testIfCanListPayloads()
	{
		$collection = $this->_api->department()->list();

		$this->assertNotEmpty($collection);
		$this->assertNotEmpty($collection->items());

		/** @var DepartmentPayload $first */
		$first = $collection->items()[0];

		$this->assertNotEmpty($first->code());
		$this->assertNotEmpty($first->description());
	}
}
