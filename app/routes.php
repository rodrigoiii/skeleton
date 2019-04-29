<?php

/**
 * Register your routes here ...
 */
$app->get('/', ["ExampleController", "index"]);
$app->get('/data', ["ExampleController", "data"]);
