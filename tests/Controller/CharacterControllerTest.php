<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CharacterControllerTest extends WebTestCase
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
     * Tests create
     */
    public function testCreate(): void
    {
        $this->client->request(
            'POST',
            '/character/create',
            array(), //parameters
            array(), //files
            array('CONTENT_TYPE' => 'application/json'), //server
            '{"kind":"Dame", "name":"Eldalótë", "surname":"Fleur elfique", "caste":"Elfe", "knowledge":"Arts", "intelligence":120, "life":12, "image":"/images/eldalote.jpg"}'
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
        $this->client->request('GET', '/character/display/' . self::$identifier);
        $this->assertJsonResponse();
        $this->assertIdentifier();
    }

    /*
     * Tests intelligenceLevel() front, application and API
     */
    public function testIntelligenceLevel()
    {
        $this->client->request('GET', '/character/intelligence/200');
        $response = $this->client->getResponse();
        $this->assertEquals(200, $response->getStatusCode());

        $this->client->request('GET', '/character/html/intelligence/200');
        $response = $this->client->getResponse();
        $this->assertEquals(200, $response->getStatusCode());

        $this->client->request('GET', '/character/api-html/intelligence/200');
        $response = $this->client->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
    }

    /**
     * Tests create
     */
    public function testModify()
    {
        //Tests with partial data array
        $this->client->request(
            'PUT',
            '/character/modify/' . self::$identifier,
            array(), //parameters
            array(), //files
            array('CONTENT_TYPE' => 'application/json'), //server
            '{"kind":"Seigneur", "name":"Gorthol"}'
        );
        $this->assertJsonResponse();
        $this->assertIdentifier();

        //Tests with whole content
        $this->client->request(
            'PUT',
            '/character/modify/' . self::$identifier,
            array(), //parameters
            array(), //files
            array('CONTENT_TYPE' => 'application/json'), //server
            '{"kind":"Seigneur", "name":"Gorthol", "surname":"Heaume de terreur", "caste":"Chevalier", "knowledge":"Diplomatie", "intelligence":110, "life":13, "image":"/images/gorthol.jpg"}'
        );
        $this->assertJsonResponse();
        $this->assertIdentifier();
    }

    /**
     * Tests delete
     */
    public function testDelete()
    {
        $this->client->request('DELETE', '/character/delete/' . self::$identifier);
        $this->assertJsonResponse();
    }

    /**
     * Tests images
     */
    public function testImage()
    {
        //Tests without kind
        $this->client->request('GET', '/character/images/3');
        $this->assertJsonResponse();

        //Tests with kind
        $this->client->request('GET', '/character/images/dames/3');
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
