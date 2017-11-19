<?php
/**
 * Created by PhpStorm.
 * User: adriano
 * Date: 18/11/17
 * Time: 13:42
 */

class Usuario
{
    public $table = 'usuario';

    public $schema = [
        'id' => PDO::PARAM_INT,
        'nome' => PDO::PARAM_STR,
        'senha' => PDO::PARAM_STR,
        'email' => PDO::PARAM_STR,
        'curso_id' => PDO::PARAM_INT,
    ];
}