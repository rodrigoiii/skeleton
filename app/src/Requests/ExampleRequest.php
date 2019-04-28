<?php

namespace App\Requests;

use Respect\Validation\Validator as v;
use Core\BaseRequest;

class ExampleRequest extends BaseRequest
{
    /**
     * Create rules using Respect Validation Library
     *
     * @return array
     */
    public function rules()
    {
        return [
            'test' => v::test()
        ];
    }
}
