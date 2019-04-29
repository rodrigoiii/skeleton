<?php

namespace App\Controllers;

use Core\BaseController;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class ExampleController extends BaseController
{
    /**
     * Display old input page
     *
     * @param  ResponseInterface $response
     * @return ResponseInterface
     */
    public function index(Response $response)
    {
        return $this->view->render($response, "old-input.twig");
    }

    public function post(Response $response)
    {
        return $response->withRedirect("/");
    }
}
