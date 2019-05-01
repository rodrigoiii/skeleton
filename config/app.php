<?php

return [
    'name' => env("APP_NAME"),
    'env' => env("APP_ENV"),
    'use_dist' => env("USE_DIST"),

    'debug' => is_dev()
];
