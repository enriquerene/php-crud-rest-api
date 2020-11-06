<?php 

use RESTfulTemplate\ResponseTemplate as ResT;
use RESTfulTemplate\SQLManager as Sman;

$container = $app->getContainer();

$container[ "rest" ] = function ( $c )
{
	return function ( $statusCode )
	{
		return new ResT( $statusCode );
	};
};

$container[ "database" ] = function ( $c )
{
    $dbInfo = $c->get( "settings" )[ "database" ];
	return new SMan( $dbInfo );
};

