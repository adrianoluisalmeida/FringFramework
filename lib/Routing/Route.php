<?php
/**
 * Created by PhpStorm.
 * User: adriano
 * Date: 09/11/17
 * Time: 23:42
 */

class Route
{
    static function set($uri, $callback)
    {

        list($class, $method) = explode('@', $callback);
        $current = Route::getCurrentUri();

        if($current == $uri){
            $controller = new $class();
            echo $controller->$method();
        }

    }

    static function getCurrentUri()
    {
        $basepath = implode('/', array_slice(explode('/', $_SERVER['SCRIPT_NAME']), 0, -1)) . '/';
        $uri = substr($_SERVER['REQUEST_URI'], strlen($basepath));
        if (strstr($uri, '?')) $uri = substr($uri, 0, strpos($uri, '?'));
        $uri = '/' . trim($uri, '/');
        return $uri;
    }

}