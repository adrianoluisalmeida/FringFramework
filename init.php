<?php

define('ROOT', dirname(__FILE__) . '/');
define('ASSETS', dirname(__FILE__) . '/public/assets');

require_once('app/model/Loader.php');
Loader::register();

require_once('app/helpers/locations.php');
require_once('app/routes.php');