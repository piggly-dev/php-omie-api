<?php

namespace Pgly\Tests\Omie\Api\Payloads;

use Pgly\Omie\Api\ApiWrapper;
use Pgly\Omie\Api\Models\ApplicationModel;
use Pgly\Omie\Api\Payloads\CityPayload;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \Pgly\Omie\Api\Endpoints\CityEndpoint
 */
class CityEndpointTest extends TestCase
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
	public function testIfCanFindExact()
	{
		$city = $this->_api->city()->findByExactName('Rio de Janeiro');

		$this->assertNotEmpty($city);
		$this->assertEquals('RIO DE JANEIRO (RJ)', $city->code());
		$this->assertEquals('RJ', $city->state());
	}

	/**
	 * @test Test if can list data.
	 * @return void
	 */
	public function testIfCanFind()
	{
		$collection = $this->_api->city()->findByName('Rio');

		$this->assertNotEmpty($collection);
		$this->assertNotEmpty($collection->items());

		/** @var CityPayload $first */
		$first = $collection->items()[0];

		$this->assertNotEmpty($first->code());
		$this->assertNotEmpty($first->state());
	}
}
