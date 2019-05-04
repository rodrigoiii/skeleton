<?php

namespace Core\Middlewares;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Core\BaseMiddleware;

class AppModeMiddleware extends BaseMiddleware
{
    /**
     * Show under maintenance page if the web mode is DOWN.
     *
     * @param  Request $request
     * @param  Response $response
     * @param  callable $next
     * @return callable
     */
    public function __invoke(Request $request, Response $response, callable $next)
    {
        $is_down = config("app.mode") === "down";

        if ($is_down)
        {
            return $this->view->render(
                        $response->withStatus(200)
                        ->withHeader('Content-Type', "text/html"),
                        config("view.error_pages.under_construction")
                    );
        }

        return $next($request, $response);
    }
}
