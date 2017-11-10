<?php
/**
 * Created by PhpStorm.
 * User: adriano
 * Date: 10/11/17
 * Time: 05:57
 */

interface InterfaceModelPDO
{
    public function save($update = []);

    public static function getAll();

    public function delete();

    public function __set($name, $value);

    public function __get($name);

    public function __isset($name);

    public function __unset($name);
}