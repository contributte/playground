<?php

namespace App\Middlewares;

use Contributte\Api\Bridges\Middlewares\ApiContentNegotiation;
use Contributte\Api\Bridges\Middlewares\ApiDataMiddleware;
use Contributte\Api\Bridges\Middlewares\ApiEmitter;
use Contributte\Api\Bridges\Middlewares\ApiRouter;
use Contributte\Api\Bridges\Middlewares\Negotiation\Transformer\JsonTransformer;
use Contributte\Api\Bridges\Middlewares\Negotiation\UrlNegotiator;
use Contributte\Api\Bridges\Tracy\Negotiation\Transformer\DebugTransformer;
use Contributte\Api\Dispatcher\IDispatcher;
use Contributte\Middlewares\ChainBuilder;
use Contributte\Middlewares\Middleware\AbstractRootMiddleware;
use Contributte\Middlewares\Middleware\AutoBasePathMiddleware;
use Contributte\Middlewares\Middleware\PresenterMiddleware;
use Contributte\Middlewares\Middleware\RouterMiddleware;
use Contributte\Middlewares\Middleware\TracyMiddleware;
use Nette\Application\IPresenterFactory;
use Nette\Application\IRouter;

final class RootMiddleware extends AbstractRootMiddleware
{

    /** @var IDispatcher @inject */
    public $apiDispatcher;

    /** @var IPresenterFactory @inject */
    public $presenterFactory;

    /** @var IRouter @inject */
    public $router;

    /**
     * @return callable
     */
    protected function create()
    {
        $chain = new ChainBuilder();
        $chain->add(new TracyMiddleware());
        $chain->add(new AutoBasePathMiddleware());
        $chain->add(new RouterMiddleware([
            '^/api/.*' => new ApiDataMiddleware([
                new ApiRouter('^/api/{api}{?format:\\.json|debug}$'),
                new ApiContentNegotiation([
                    new UrlNegotiator([
                        'json' => new JsonTransformer(),
                        'debug' => new DebugTransformer(),
                        '*' => new JsonTransformer(),
                    ]),
                ]),
                new ApiEmitter($this->apiDispatcher),
            ]),
            '.*' => new PresenterMiddleware($this->presenterFactory, $this->router),
        ]));

        return $chain->create();
    }

}
