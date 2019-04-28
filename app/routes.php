<?php

/**
 * Register your routes here ...
 */
$app->get('/', ["ExampleController", "index"]);

$app->post('/', ["ExampleController", "post"]);
