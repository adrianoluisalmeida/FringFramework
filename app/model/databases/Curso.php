<?php
/**
 * Created by PhpStorm.
 * User: adriano
 * Date: 13/11/17
 * Time: 21:20
 */

class Curso{
    public $table = 'curso';

    public $schema = [
        'id' => PDO::PARAM_INT,
        'nome' => PDO::PARAM_STR,
        'semestres' => PDO::PARAM_INT,
        'vagas' => PDO::PARAM_INT,
        'departamento' => PDO::PARAM_STR,
        'apresentacao' => PDO::PARAM_STR,
        'disciplinas' => []
    ];
}