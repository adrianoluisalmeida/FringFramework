<?php


class Loader
{

    static $paths = array(
        'app/model/util/',
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
        $database = include(ROOT . 'app/config/database.php');
        self::$paths = array_merge(self::$paths, ['app/model/' . $database['dbdrive'] . '/']);

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