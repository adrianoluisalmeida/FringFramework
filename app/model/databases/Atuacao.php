<?php
/**
 * Created by PhpStorm.
 * User: adriano
 * Date: 13/11/17
 * Time: 21:20
 */

class Atuacao{
    public $table = 'atuacao';

    public $schema = [
        'id' => PDO::PARAM_INT,
        'nome' => PDO::PARAM_STR,
    ];
}