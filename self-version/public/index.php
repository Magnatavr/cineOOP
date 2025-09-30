<?php

use App\Kernel\App;

require_once dirname(__DIR__) . "/config/constants.php";
require_once dirname(__DIR__). "/vendor/autoload.php";



$app = new App();

$app->run();




