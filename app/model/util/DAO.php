<?php
/**
 * Created by PhpStorm.
 * User: adriano
 * Date: 14/11/17
 * Time: 10:04
 */

interface DAO
{
    public function save($model, $update = []);
    public function getAll($model);
    public function getAllBy($model, array $where = NULL);
    public function get($model, $id);
}