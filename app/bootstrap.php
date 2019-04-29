<?php

# create environment
$dotEnv = Core\App::createEnvironment();
$dotEnv->overload();
$dotEnv->required("APP_NAME")->notEmpty();
$dotEnv->required("APP_ENV")->allowedValues(["development", "production"]);
$dotEnv->required("DB_HOSTNAME");
$dotEnv->required("DB_PORT")->isInteger();
$dotEnv->required("DB_USERNAME");
$dotEnv->required("DB_PASSWORD");
$dotEnv->required("DB_NAME");
$dotEnv->required("DEBUG_BAR_ON");

# application instance
$app = new Core\App;
$app->loadDatabaseConnection();

# load libraries
require core_path("libraries/debugbar.php");

# load middlewares
if (is_dev() && filter_var(env('DEBUG_BAR_ON'), FILTER_VALIDATE_BOOLEAN) && PHP_SAPI !== "cli")
{
    $app->add(new RunTracy\Middlewares\TracyMiddleware($app));
}

# routes
require app_path("routes.php");

# run the application
$app->run();
