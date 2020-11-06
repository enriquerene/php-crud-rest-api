<?php

namespace App\Test;

use PHPUnit\Framework\TestCase;
use GuzzleHttp\Client;

class CRUDTest extends TestCase
{
	/**
	 * @var string HOSTNAME The URL basename for requests.
	 */
	const HOSTNAME = "http://localhost:8080" ;

	/**
	 * @var array MOCK_CAR A car example for mocking in tests.
	 */
	const MOCK_CAR = [
		"model" => "Onix",
		"brand" => "Chevrolet",
		"year" => "2010"
	];

	/**
	 * @var GuzzleHttp\Client $client Guzzle HTTP Client Instance.
	 */
	private $client;

	/**
	 * Set up HTTP client.
	 */
	public function setUp (): void
	{
		$this->client = new Client( [ "base_uri" => $this->HOSTNAME ] );
	}

	/**
	 * Test POST request to Create a resource (Crud)
	 */
	public function testCreate ()
	{
		$response = $this->client->request(
			"POST",
			"/cars",
			[ "json" => $this->MOCK_CAR ]
		);
		$this->assertEquals( 201, $response->getStatusCode() );
	}

	/**
	 * Test GET request to Read a resource (cRud)
	 */
	public function testRead ()
	{
		$response = $this->client->request( "GET", "/cars/1" );
		$this->assertEquals( 200, $response->getStatusCode() );
		
		$body = $response->getBody();
		$json = json_decode( $body, true );
		$data = $json[ "data" ];
		$this->assertEquals( $data[ "model" ], $this->MOCK_CAR[ "model" ] );
		$this->assertEquals( $data[ "brand" ], $this->MOCK_CAR[ "brand" ] );
		$this->assertEquals( $data[ "year" ], $this->MOCK_CAR[ "year" ] );
	}

	/**
	 * Test GET request to Read many resources (cRud)
	 */
	public function testReadAll ()
	{
		$response = $this->client->request( "GET", "/cars" );
		$this->assertEquals( 200, $response->getStatusCode() );

		$body = $response->getBody();
		$json = json_decode( $body, true );
		$data = $json[ "data" ][ 0 ];
		$this->assertEquals( $data[ "model" ], $this->MOCK_CAR[ "model" ] );
		$this->assertEquals( $data[ "brand" ], $this->MOCK_CAR[ "brand" ] );
		$this->assertEquals( $data[ "year" ], $this->MOCK_CAR[ "year" ] );
	}

	/**
	 * Test PUT request to Update a resource (crUd)
	 */
	public function testUpdate ()
	{
		$mockCar = $this->MOCK_CAR;
		$mockCar[ "year" ] = "2011";
		$response = $this->client->request(
			"PUT",
			"/cars/1",
			[ "json" => $mockCar ]
		);
		$this->assertEquals( 200, $response->getStatusCode() );

		$body = $response->getBody();
		$json = json_decode( $body, true );
		$data = $json[ "data" ][ 0 ];
		$this->assertEquals( $data[ "model" ], $mockCar[ "model" ] );
		$this->assertEquals( $data[ "brand" ], $mockCar[ "brand" ] );
		$this->assertEquals( $data[ "year" ], $mockCar[ "year" ] );
	}

	/**
	 * Test DELETE request to Delete a resource (cruD)
	 */
	public function testDelete ()
	{
		$response = $this->client->request( "DELETE", "/cars/1" );
		$this->assertEquals( 200, $response->getStatusCode() );
	}
}
