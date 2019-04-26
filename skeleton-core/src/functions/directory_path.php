<?php

/**
 * Return the root path of application.
 *
 * @param  string $str
 * @return string
 */
function base_path($str = "")
{
    $is_own_server = count(glob($_SERVER['DOCUMENT_ROOT'] . "/.env")) === 0;

    $root = $_SERVER[PHP_SAPI !== "cli" ? "DOCUMENT_ROOT" : "PWD"];
    $root .= $is_own_server ? "/.." : "";

    $str = !empty($str) ? ("/" . trim($str)) : "";

    return $root . $str;
}

/**
 * Return the app path of application.
 *
 * @param  string $str
 * @return string
 */
function app_path($str = "")
{
    $str = !empty($str) ? ("/" . trim($str)) : "";
    return base_path("app") . $str;
}

/**
 * Return the config path of application.
 *
 * @param  string $str
 * @return string
 */
function config_path($str = "")
{
    $str = !empty($str) ? ("/" . trim($str)) : "";
    return base_path("config") . $str;
}

/**
 * Return the database path of application.
 *
 * @param  string $str
 * @return string
 */
function database_path($str = "")
{
    $str = !empty($str) ? ("/" . trim($str)) : "";
    return base_path("database") . $str;
}

/**
 * Return the public path of application.
 *
 * @param  string $str
 * @return string
 */
function public_path($str = "")
{
    $str = !empty($str) ? ("/" . trim($str)) : "";
    return base_path("public") . $str;
}

/**
 * Return the resources path of application.
 *
 * @param  string $str
 * @return string
 */
function resources_path($str = "")
{
    $str = !empty($str) ? ("/" . trim($str)) : "";
    return base_path("resources") . $str;
}

/**
 * Return the storage path of application.
 *
 * @param  string $str
 * @return string
 */
function storage_path($str = "")
{
    $str = !empty($str) ? ("/" . trim($str)) : "";
    return base_path("storage") . $str;
}
