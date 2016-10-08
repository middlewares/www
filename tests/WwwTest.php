<?php

namespace Middlewares\Tests;

use Middlewares\Www;
use Zend\Diactoros\Request;
use Zend\Diactoros\Response;
use mindplay\middleman\Dispatcher;

class WwwTest extends \PHPUnit_Framework_TestCase
{
    public function wwwProvider()
    {
        return [
            [true, 'http://localhost', 'http://localhost'],
            [true, 'http://localhost.com', 'http://www.localhost.com'],
            [true, 'http://example.com', 'http://www.example.com'],
            [true, 'http://example.co.uk', 'http://www.example.co.uk'],
            [true, 'http://www.example.com', 'http://www.example.com'],
            [true, 'http://ww1.example.com', 'http://ww1.example.com'],
            [true, 'http://0.0.0.0', 'http://0.0.0.0'],
            [true, '', ''],
            [false, 'http://localhost', 'http://localhost'],
            [false, 'http://www.localhost.com', 'http://localhost.com'],
            [false, 'http://www.example.com', 'http://example.com'],
            [false, 'http://www.example.co.uk', 'http://example.co.uk'],
            [false, 'http://www.example.com', 'http://example.com'],
            [false, 'http://ww1.example.com', 'http://ww1.example.com'],
            [false, '', ''],
        ];
    }

    /**
     * @dataProvider wwwProvider
     */
    public function testAddWww($add, $uri, $result)
    {
        $response = (new Dispatcher([
            new Www($add),
            function () {
                return new Response();
            },
        ]))->dispatch(new Request($uri));

        $this->assertInstanceOf('Psr\\Http\\Message\\ResponseInterface', $response);

        if ($uri === $result) {
            $this->assertEquals(200, $response->getStatusCode());
        } else {
            $this->assertEquals(301, $response->getStatusCode());
            $this->assertEquals($result, $response->getHeaderLine('Location'));
        }
    }
}
