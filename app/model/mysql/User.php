<?php
/**
 * Created by PhpStorm.
 * User: adriano
 * Date: 10/11/17
 * Time: 00:56
 */

class User extends ModelPDO
{

    public function __construct()
    {
        $schema = array(
            'id' => PDO::PARAM_INT,
            'nome' => PDO::PARAM_STR,
            'email' => PDO::PARAM_STR
        );
        parent::__construct($schema);
    }

}