<?php

class Request
{

    static public function getParam($param)
    {
        return filter_input(INPUT_GET, $param, FILTER_SANITIZE_ENCODED);
    }

    static public function all($fields = [])
    {

        $inputs = new stdClass();
        foreach ($fields as $key) {
            $inputs->$key = self::sanitizeString($key);
        }

        return $inputs;
    }

    public function sanitizeString($name)
    {
        return filter_input(INPUT_POST, $name, FILTER_SANITIZE_STRING);
    }

    static public function getPost($name){
        return self::sanitizeString($name);
    }


}