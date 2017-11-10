<?php
/**
 * Created by PhpStorm.
 * User: adriano
 * Date: 10/11/17
 * Time: 06:14
 */

class Example extends ModelMDB
{

    public function __construct()
    {
        $schema = array(
            'id' => PDO::PARAM_INT,
            'name' => PDO::PARAM_STR,
            'email' => PDO::PARAM_STR,
            'phone' => PDO::PARAM_STR
        );
        parent::__construct($schema);
    }

}