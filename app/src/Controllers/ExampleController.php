<?php

namespace App\Controllers;

use App\Requests\ExampleRequest;
use Core\BaseController;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class ExampleController extends BaseController
{
    /**
     * Display home page
     *
     * @param  ResponseInterface $response
     * @return ResponseInterface
     */
    public function index(Response $response)
    {
        return $this->view->render($response, "home.twig");
    }

    /**
     * Example post endpoint
     *
     * @param  ExampleRequest $_request [do not use $request variable]
     * @return void
     */
    public function post(ExampleRequest $_request)
    {
        die('success');
    }
}
