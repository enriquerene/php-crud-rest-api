<?php

header( "Access-Control-Allow-Origin: *" );
header("Access-Control-Allow-Headers: Content-Type" );
header( "Access-Control-Allow-Methods: GET, POST, PUT, DELETE" );

require "../vendor/autoload.php";

use Slim\App;

$settings = require "../src/settings.php";
$app = new App( $settings );

require "../src/dependencies.php";
require "../src/middlewares.php";
require "../src/routes.php";

$app->run();
