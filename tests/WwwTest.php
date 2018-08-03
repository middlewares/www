<?php
declare(strict_types = 1);

namespace Middlewares\Tests;

use Middlewares\Utils\Dispatcher;
use Middlewares\Utils\Factory;
use Middlewares\Www;
use PHPUnit\Framework\TestCase;

class WwwTest extends TestCase
{
    public function wwwProvider()
    {
        return [
            [true, 'http://localhost', 'http://localhost'],
            [true, 'http://localhost.com', 'http://www.localhost.com'],
            [true, 'http://example.com', 'http://www.example.com'],
            [true, 'http://example.co.uk', 'http://www.example.co.uk'],
            [true, 'http://www.example.com', 'http://www.example.com'],
            [true, 'http://ww1.example.com', 'http://www.ww1.example.com'],
            [true, 'http://0.0.0.0', 'http://0.0.0.0'],
            [true, '', ''],
            [false, 'http://localhost', 'http://localhost'],
            [false, 'http://www.localhost.com', 'http://localhost.com'],
            [false, 'http://www.example.com', 'http://example.com'],
            [false, 'http://www.example.co.uk', 'http://example.co.uk'],
            [false, 'http://www.example.com', 'http://example.com'],
            [false, 'http://ww1.example.com', 'http://ww1.example.com'],
            [true, 'http://sub.domain.example.com', 'http://www.sub.domain.example.com'],
            [false, '', ''],
        ];
    }

    /**
     * @dataProvider wwwProvider
     */
    public function testAddWww(bool $add, string $uri, string $result)
    {
        $request = Factory::createServerRequest('GET', $uri);

        $response = Dispatcher::run([
            new Www($add),
        ], $request);

        if ($uri === $result) {
            $this->assertEquals(200, $response->getStatusCode());
        } else {
            $this->assertEquals(301, $response->getStatusCode());
            $this->assertEquals($result, $response->getHeaderLine('Location'));
        }
    }
}
