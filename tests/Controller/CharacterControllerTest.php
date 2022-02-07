<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CharacterControllerTest extends WebTestCase
{
    /**
     * Tests redirect index
     */
    public function testRedirectIndex(): void
    {
        $client = static::createClient();
        $client->request('GET', '/character');

        $this->assertEquals(302, $client->getResponse()->getStatusCode());
    }

    /**
     * Tests index
     */
    public function testIndex(): void
    {
        $client = static::createClient();
        $client->request('GET', '/character/index');

        $this->assertJsonResponse($client->getResponse());
    }

    /**
     * Tests display
     */
    public function testDisplay(): void
    {
        $client = static::createClient();
        $client->request('GET', '/character/display/01fd9fbae5d47c1a0a98fde938ba44f2d9257d6f');

        $this->assertJsonResponse($client->getResponse());
    }

    /**
     * Tests create
     */
    public function testCreate(): void
    {
        $client = static::createClient();
        $client->request('POST', '/character/create');

        $this->assertJsonResponse($client->getResponse());
    }

    /**
     * Asserts that a Response is in json
     */
    public function assertJsonResponse($response)
    {
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertTrue($response->headers->contains('Content-Type', 'application/json'), $response->headers);
    }
}
