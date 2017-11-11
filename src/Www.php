<?php
declare(strict_types = 1);

namespace Middlewares;

use Interop\Http\Server\MiddlewareInterface;
use Interop\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class Www implements MiddlewareInterface
{
    /**
     * @var bool Add or remove www
     */
    private $www = false;

    /**
     * Configure whether the www subdomain should be added or removed.
     *
     * @param bool $www
     */
    public function __construct(bool $www = false)
    {
        $this->www = $www;
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
            return Utils\Factory::createResponse(301)
                ->withHeader('Location', (string) $uri->withHost($host));
        }

        return $handler->handle($request);
    }

    /**
     * Check whether the domain can add a www. subdomain.
     * Returns false if:
     * - the host is "localhost"
     * - the host is a ip
     * - the host has already a subdomain, for example "subdomain.example.com".
     */
    private static function wwwCanBeAdded(string $host): bool
    {
        if (empty($host) || filter_var($host, FILTER_VALIDATE_IP)) {
            return false;
        }

        $host = explode('.', $host);

        switch (count($host)) {
            case 1: //localhost (or similar)
                return false;
            case 2: //example.com
                return true;
            case 3: //example.co.uk
                return $host[1] === 'co';
            default:
                return false;
        }
    }
}
