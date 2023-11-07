<?php

namespace App\Tests\Security;

use App\Entity\User;
use App\Security\GithubUserProvider;
use GuzzleHttp\Client;
use JMS\Serializer\Serializer;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

class GithubUserProviderTest extends TestCase
{
    private MockObject | Client | null $client;
    private MockObject | Serializer | null $serializer;
    private MockObject | StreamInterface | null $streamedResponse;
    private MockObject | ResponseInterface | null $response;


    public function setUp(): void
    {
        $this->client = $this->getMockBuilder('GuzzleHttp\Client')
            ->disableOriginalConstructor()
            ->setMethods(['get'])
            ->getMock();

        $this->serializer = $this->getMockBuilder('JMS\Serializer\Serializer')
            ->disableOriginalConstructor()
            ->getMock();

        $this->response = $this->getMockBuilder('Psr\Http\Message\ResponseInterface')
            ->getMock();

        $this->streamedResponse = $this->getMockBuilder('Psr\Http\Message\StreamInterface')
            ->getMock();
    }


    public function testLoadUserByUsernameReturningAUser()
    {
        $this->client->expects($this->once())
            ->method('get')
            ->willReturn($this->response);

        $this->response->expects($this->once())
            ->method('getBody')
            ->willReturn($this->streamedResponse);

        $this->streamedResponse->expects($this->once())
            ->method('getContents')
            ->willReturn('foo');

        $userData = ['login' => 'a login', 'name' => 'user name', 'email' => 'adress@mail.com', 'avatar_url' => 'url of avatar', 'html_url' => 'url of html'];

        $this->serializer->expects($this->once())
            ->method('deserialize')
            ->willReturn($userData);

        $githubUserProvider = new GithubUserProvider($this->client, $this->serializer);
        $user = $githubUserProvider->loadUserByUsername('an-access-token');

        $expectedUser = new User($userData['login'], $userData['name'], $userData['email'], $userData['avatar_url'], $userData['html_url']);

        $this->assertEquals($expectedUser, $user);
        $this->assertEquals('App\Entity\User', get_class($user));
    }


    public function testLoadUserByUsernameThrowingException()
    {
        $this->client->expects($this->once()) 
            ->method('get')
            ->willReturn($this->response);

        $this->response->expects($this->once())
            ->method('getBody')
            ->willReturn($this->streamedResponse);

        $this->streamedResponse->expects($this->once())
            ->method('getContents')
            ->willReturn('foo');

        $this->serializer->expects($this->once())
            ->method('deserialize')
            ->willReturn([]);

        $this->expectException('LogicException');
        $githubUserProvider = new GithubUserProvider($this->client, $this->serializer);
        $githubUserProvider->loadUserByUsername('an-access-token');
    }

    public function tearDown() : void
    {
        $this->client = null;
        $this->serializer = null;
        $this->streamedResponse = null;
        $this->response = null;
    }
}
