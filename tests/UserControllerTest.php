<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UsersControllerTest extends WebTestCase
{
    public function testGetUsers()   
    {
        $user = static::createClient();
        $user->request('GET', '/api/users', [], [], ['HTTP_ACCEPT' => 'application/json']);
        $response = $user->getResponse();$content = $response->getContent();
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertJson($content);
        $arrayContent = \json_decode($content, true);
        $this->assertCount(15, $arrayContent);
    }

    public function testPostUsers()
    {
        $user = static::createClient();
        $user->request('POST', '/api/users', [], [],
        [
        'HTTP_ACCEPT' => 'application/json',
        'CONTENT_TYPE' => 'application/json',
        ],
        '{"apiKey": "S8@PL.IJK","email": "rubye771@hotmail.com", "createdAt": "1997-10-03 10:43:07", "password": "1234"}');
        $response = $user->getResponse();
        $content = $response->getContent();
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertJson($content);
    }

}