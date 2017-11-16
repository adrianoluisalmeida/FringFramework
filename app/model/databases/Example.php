<?php
/**
 * Created by PhpStorm.
 * User: adriano
 * Date: 13/11/17
 * Time: 21:20
 */

class Example
{
    public $table = 'examples';

    public $schema = [
        'id' => PDO::PARAM_INT,
        'name' => PDO::PARAM_STR,
        'email' => PDO::PARAM_STR,
        'phone' => PDO::PARAM_STR,
    ];
}