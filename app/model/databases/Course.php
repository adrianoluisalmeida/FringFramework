<?php
/**
 * Created by PhpStorm.
 * User: adriano
 * Date: 13/11/17
 * Time: 21:20
 */

class Course{
    public $table = 'courses';

    public $schema = [
        'id' => PDO::PARAM_INT,
        'name' => PDO::PARAM_STR,
    ];
}