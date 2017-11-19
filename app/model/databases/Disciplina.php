<?php
/**
 * Created by PhpStorm.
 * User: adriano
 * Date: 13/11/17
 * Time: 21:20
 */

class Disciplina{
    public $table = 'disciplina';

    public $schema = [
        'id' => PDO::PARAM_INT,
        'nome' => PDO::PARAM_STR,
        'codigo' => PDO::PARAM_STR,
        'objetivos' => PDO::PARAM_STR,
        'programa' => PDO::PARAM_STR,
//        'bibliografia' => PDO::PARAM_STR,
        'curso_id' => PDO::PARAM_INT,
    ];
}