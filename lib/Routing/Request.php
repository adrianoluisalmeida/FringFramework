<?php

class Request
{

    static public function getParam($param)
    {
        return filter_input(INPUT_GET, $param, FILTER_SANITIZE_ENCODED);
    }


}