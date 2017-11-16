<?php
/**
 * Created by PhpStorm.
 * User: adriano
 * Date: 10/11/17
 * Time: 03:08
 */

$active_db = 'mysql'; //qual será a base usada mongodb ou mysql
//$active_db = 'mongodb'; //qual será a base usada mongodb ou mysql

$groups = [
    'mysql' => [
        'dbdrive' => 'mysql',
        'hostname' => 'localhost',
        'username' => 'root',
        'passwd' => 'root',
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