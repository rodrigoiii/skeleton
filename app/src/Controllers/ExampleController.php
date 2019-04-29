<?php

namespace App\Controllers;

use Core\BaseController;
use Core\Utilities\DataTable;
use Illuminate\Database\Capsule\Manager;
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
        return $this->view->render($response, "datatable.twig");
    }

    /**
     * Fetch all models in database then return it as json.
     *
     * @param  Request $request
     * @param  Response $response
     * @return json
     */
    public function data(Request $request, Response $response)
    {
        $data = $request->getParams();
        $query_builder = Manager::table('users');
        $columns = ["id", "first_name", "last_name", "email", "password"];

        $dataTable = new DataTable($data, $query_builder, $columns);

        return $response->withJson($dataTable->getResponse());
    }
}
