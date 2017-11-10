<?php
/**
 * Created by PhpStorm.
 * User: adriano
 * Date: 10/11/17
 * Time: 03:08
 */

$active_db = 'mongodb';

$groups = [
    'pdo' => [
        'dbdrive' => 'mysql',
        'hostname' => 'localhost',
        'username' => 'root',
        'passwd' => '',
        'dbname' => 'gbd'
    ],
    'mongodb' => [
        'dbdrive' => 'mongodb',
        'hostname' => 'localhost',
        'port' => '27017',
        'dbname' => 'gbd'
    ]
];

return $groups[$active_db];