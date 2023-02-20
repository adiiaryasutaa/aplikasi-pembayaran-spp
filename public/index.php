<?php

use Core\Foundation\Application;

require_once(__DIR__ . '/../loader.php');

$configs = require_once(__DIR__ . '/../app/config/app.php');

$app = new Application($configs);

$app->start();