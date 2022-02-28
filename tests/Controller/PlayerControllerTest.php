<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PlayerControllerTest extends WebTestCase
{
    private $client;
    private $content;
    private static $identifier;

    public function setUp(): void
    {
        $this->client = static::createClient();
    }

    /**
     * Tests redirect index
     */
    public function testRedirectIndex(): void
    {
        $this->client->request('GET', '/player');

        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());
    }

    /**
     * Tests index
     */
    public function testIndex(): void
    {
        $this->client->request('GET', '/player/index');

        $this->assertJsonResponse();
    }

    /**
     * Tests badIdentifier
     */
    public function testBadIdentifier()
    {
        $this->client->request('GET', '/player/display/badIdentifier');

        $this->assertError404($this->client->getResponse()->getStatusCode());
    }

    /**
     * Tests inexistingIdentifier
     */
    public function testInexistingIdentifier()
    {
        $this->client->request('GET', '/player/display/10548fehs695g4foda2clf8r3s4c6l5e8f9error');
        $this->assertError404($this->client->getResponse()->getStatusCode());
    }

    /**
     * Tests create
     */
    public function testCreate(): void
    {
        $this->client->request(
            'POST',
            '/player/create',
            array(), //parameters
            array(), //files
            array('CONTENT_TYPE' => 'application/json'), //server
            '{"firstname":"Eldalótë","lastname":"Fleur","email":"elfe@trap.com","mirian":"500"}'
        );
        $this->assertJsonResponse();
        $this->defineIdentifier();
        $this->assertIdentifier();
    }

    /**
     * Tests display
     */
    public function testDisplay(): void
    {
        $this->client->request('GET', '/player/display/' . self::$identifier);
        $this->assertJsonResponse();
        $this->assertIdentifier();
    }

    /**
     * Tests create
     */
    public function testModify()
    {
        //Tests with partial data array
        $this->client->request(
            'PUT',
            '/player/modify/' . self::$identifier,
            array(), //parameters
            array(), //files
            array('CONTENT_TYPE' => 'application/json'), //server
            '{"firstname":"Suuuuuu", "lastname":"Gorthol"}'
        );
        $this->assertJsonResponse();
        $this->assertIdentifier();

        //Tests with whole content
        $this->client->request(
            'PUT',
            '/player/modify/' . self::$identifier,
            array(), //parameters
            array(), //files
            array('CONTENT_TYPE' => 'application/json'), //server
            '{"firstname":"Eldalótë","lastname":"Fleur","email":"elfe@trap.com","mirian":"500"}'
        );
        $this->assertJsonResponse();
        $this->assertIdentifier();
    }

    /**
     * Tests delete
     */
    public function testDelete()
    {
        $this->client->request('DELETE', '/player/delete/' . self::$identifier);
        $this->assertJsonResponse();
    }

    /**
     * Asserts that a Response is in json
     */
    public function assertJsonResponse()
    {
        $response = $this->client->getResponse();
        $this->content = json_decode($response->getContent(), true, 50);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertTrue($response->headers->contains('Content-Type', 'application/json'), $response->headers);
    }

    /**
     * Asserts that 'identifier' is present in the Response
     */
    public function assertIdentifier()
    {
        $this->assertArrayHasKey('identifier', $this->content);
    }

    /**
     * Defines identifier
     */
    public function defineIdentifier()
    {
        self::$identifier = $this->content['identifier'];
    }

    /**
     * Asserts that Response returns 404
     */
    public function assertError404($statusCode)
    {
        $this->assertEquals(404, $statusCode);
    }
}
