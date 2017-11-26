<?php
/**
 * Created by PhpStorm.
 * User: adriano
 * Date: 10/11/17
 * Time: 03:08
 */

//$active_db = 'mysql'; //qual será a base usada mongodb ou mysql
//$active_db = 'pgsql'; //qual será a base usada mongodb ou mysql
$active_db = 'mongodb'; //qual será a base usada mongodb ou mysql

$groups = [
    'mysql' => [
        'dbdrive' => 'mysql',
        'hostname' => '',
        'username' => 'root',
        'passwd' => '968574',
        'dbname' => 'gbd',
        'charset' => ';charset=utf8'
    ],
    'pgsql' => [
        'dbdrive' => 'pgsql',
        'hostname' => ';host=localhost',
        'username' => 'postgres',
        'passwd' => '1234',
        'dbname' => 'gbd',
        'charset' => ''
    ],
    'mongodb' => [
        'dbdrive' => 'mongodb',
        'hostname' => 'localhost',
        'port' => '27017',
        'dbname' => 'gbd'
    ],

];

return $groups[$active_db];


