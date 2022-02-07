<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CharacterControllerTest extends WebTestCase
{
    private $client;

    public function setUp(): void
    {
        $this->client = static::createClient();
    }

    /**
     * Tests redirect index
     */
    public function testRedirectIndex(): void
    {
        $this->client->request('GET', '/character');

        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());
    }

    /**
     * Tests index
     */
    public function testIndex(): void
    {
        $this->client->request('GET', '/character/index');

        $this->assertJsonResponse();
    }

    /**
     * Tests badIdentifier
     */
    public function testBadIdentifier()
    {
        $this->client->request('GET', '/character/display/badIdentifier');

        $this->assertError404($this->client->getResponse()->getStatusCode());
    }

    /**
     * Tests inexistingIdentifier
     */
    public function testInexistingIdentifier()
    {
        $this->client->request('GET', '/character/display/10548fehs695g4foda2clf8r3s4c6l5e8f9error');
        $this->assertError404($this->client->getResponse()->getStatusCode());
    }

    /**
     * Tests display
     */
    public function testDisplay(): void
    {
        $this->client->request('GET', '/character/display/01fd9fbae5d47c1a0a98fde938ba44f2d9257d6f');

        $this->assertJsonResponse();
    }

    /**
     * Tests create
     */
    public function testCreate(): void
    {
        $this->client->request('POST', '/character/create');

        $this->assertJsonResponse();
    }

    /**
     * Asserts that a Response is in json
     */
    public function assertJsonResponse()
    {
        $response = $this->client->getResponse();

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertTrue($response->headers->contains('Content-Type', 'application/json'), $response->headers);
    }

    /**
     * Asserts that Response returns 404
     */
    public function assertError404($statusCode)
    {
        $this->assertEquals(404, $statusCode);
    }
}
