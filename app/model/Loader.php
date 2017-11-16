<?php


class Loader
{

    static $paths = array(
        'app/model/util/',
        'app/model/testes/',
        'app/controller/',
        'app/helpers/',
        'lib/Twig/',
        'lib/Routing/'
    );

    static function register()
    {
        spl_autoload_register('Loader::load');
    }

    static function load($name)
    {

        $name = preg_replace('/Twig_/', '', $name, 1);
        if (class_exists($name, false)) return;

        foreach (self::$paths as $path) {

            $filename = ROOT . $path . $name . '.php';
            if (file_exists($filename)) {
                require_once($filename);
                return;
            }
        }
    }

}