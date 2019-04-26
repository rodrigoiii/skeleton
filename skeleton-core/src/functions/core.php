<?php

/**
 * Access the configuration at the config folder.
 *
 * @param  string $string
 * @return string
 */
function config($string)
{
    $temp = explode(".", $string);

    $filename = array_shift($temp);
    $keys = $temp;

    $content = include config_path("{$filename}.php");

    $active = $content;
    foreach ($keys as $key) {
        $active = $active[$key];
    }
    return $active;
}

/**
 * Call contant of class
 *
 * @param string $class
 * @param string $contant
 * @return mixed
 */
function class_constant()
{
    $args = func_get_args();

    $class = array_shift($args);
    $contant = array_shift($args);

    return $class::$contant;
}


/**
 * Return application namespace.
 *
 * @return string
 */
function get_app_namespace()
{
    $composer_json_file = base_path("composer.json");

    $composer_json_decode = json_decode(file_get_contents($composer_json_file), true);

    $app_namespace = array_search("app", array_map(function($psr_4) {
        return trim($psr_4, "/");
    }, $composer_json_decode['autoload']['psr-4']));

    return $app_namespace;
}
