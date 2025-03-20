<?php
declare(strict_types = 1);

namespace Middlewares;

use Middlewares\Utils\Factory;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class Www implements MiddlewareInterface
{
    /**
     * @var bool
     */
    private $www;

    /**
     * @var ResponseFactoryInterface
     */
    private $responseFactory;

    /**
     * Configure whether the www subdomain should be added or removed.
     */
    public function __construct(bool $www, ?ResponseFactoryInterface $responseFactory = null)
    {
        $this->www = $www;
        $this->responseFactory = $responseFactory ?: Factory::getResponseFactory();
    }

    /**
     * Process a request and return a response.
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $uri = $request->getUri();
        $host = $uri->getHost();

        if ($this->www) {
            if (self::wwwCanBeAdded($host)) {
                $host = sprintf('www.%s', $host);
            }
        } elseif (strpos($host, 'www.') === 0) {
            $host = substr($host, 4);
        }

        if ($uri->getHost() !== $host) {
            return $this->responseFactory->createResponse(301)
                ->withHeader('Location', (string) $uri->withHost($host));
        }

        return $handler->handle($request);
    }

    /**
     * Check whether the domain can add a www. subdomain.
     */
    private static function wwwCanBeAdded(string $host): bool
    {
        //is an ip?
        if (empty($host) || filter_var($host, FILTER_VALIDATE_IP)) {
            return false;
        }

        //is "localhost" or similar?
        $pieces = explode('.', $host);

        return count($pieces) > 1 && $pieces[0] !== 'www';
    }
}
