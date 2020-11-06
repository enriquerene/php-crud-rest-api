<?php

use Slim\Http\Request;
use Slim\Http\Response;

/**
 * Read many rows at time
 *
 * @param $tableName Required route parameter for table name to fetch data from.
 * @param [$fieldName] Optoinal GET request parameter column name with field value to be fetched.
 * @param $qType Optional GET request parameter for query type: like | interval.
 * @param $fields Optional GET request parameter with requested fields only.
 * @param $perPage Optional GET request parameter for how many results per page must be fetched.
 * @param $page Optional GET request parameter for current page.
 */
$rt[ "readAll" ] = function ( Request $request, Response $response, array $args )
{
    $db = $this->database;
    $tableName = $args[ "tableName" ];
    if ( $db->isTable( $tableName ) ) {
		$fields = $request->getParam( "fields", [] );
		if ( ! empty( $fields ) ) {
			$fields = explode( ",", $fields );
		}
		// aqui!!!
		$where = $request->getQueryParams();
		$perPage = $request->getQueryParam( "perPage" );
		$page = $request->getQueryParam( "page", 1 );
		if ( ! empty( $perPage ) ) {
			$offset = $perPage * ( $page - 1 );
			$db->setSelectLimit( $perPage, $offset );
		}
		unset(
			$where[ "fields" ],
			$where[ "qType" ],
			$where[ "perPage" ],
			$where[ "page" ]
		);
		switch ( $request->getQueryParam( "qType" ) ) {
			case "like":
				$db->setWhereType( "like" );
				$data = $db->select( $tableName, $fields, $where );
				break;
			case "interval":
				break;
			case "csv":
				break;
			default:
				$data = $db->select( $tableName, $fields, $where );
				break;
		}
		$rest = $this->rest( 200 );
		$res = $rest->build( $data );
    } else {
		$rest = $this->rest( 404 );
		$res = $rest->build();
    }
    return $response->withJson( $res );
};

/**
 * Write new row
 *
 * @param $tableName Required route parameter for table name to insert data into.
 */
$rt[ "create" ] = function ( Request $request, Response $response, array $args )
{
    $db = $this->database;
    $tableName = $args[ "tableName" ];
    if ( $db->isTable( $tableName ) ) {
		$body = $request->getParsedBody();
		if ( empty( $body ) )
		{
			$rest = $this->rest( 400 );
			return $response->withJson( $rest->build() );
		}
		$restult = $db->insert( $tableName, $body );
		$statusCode = ( $restult !== false ) ? 201 : 500;
		{
			$rest = $this->rest( $statusCode );
		}
    } else {
		$rest = $this->rest( 404 );
	}
    return $response->withJson( $rest->build() );
};

/**
 * Read a row from ID
 *
 * @param $tableName Required route parameter for table name to fetch data from.
 * @param $id Required route parameter ID of the row to be fetched.
 */
$rt[ "read" ] = function ( Request $request, Response $response, array $args )
{
    $db = $this->database;
	$tableName = $args[ "tableName" ];
	$id = $args[ "id" ];
	if ( empty( $id ) )
		return $response->withJson( $this->rest( 400 )->build() );

    $where = [ "id" => $id ];
	$statusCode = 404;
	$data = null;
	if ( $db->isTable( $tableName ) )
	{
		$data = $db->select( $tableName, [], $where );
		if ( ! empty( $data ) )
			$statusCode = 200;
    }
	$rest = $this->rest( $statusCode );
    return $response->withJson( $rest->build( $data ) );
};

/**
 * Update row from ID
 *
 * @param $tableName Required route parameter for table name to fetch data from.
 * @param $id Required route parameter ID of the row to be updated.
 */
$rt[ "update" ] = function ( Request $request, Response $response, array $args )
{
    $db = $this->database;
    $tableName = $args[ "tableName" ];
	$id = $args[ "id" ];
	if ( empty( $id ) )
		return $response->withJson( $this->rest( 400 )->build() );

    $where = [ "id" => $id ];
    if ( $db->isTable( $tableName ) ) {
		$body = $request->getParsedBody();
		if ( empty( $body ) )
		{
			$rest = $this->rest( 400 );
			return $response->withJson( $rest->build() );
		}
		$result = $db->update( $tableName, $body, $where );
		if ( $result !== false ) {
			$statusCode = 200;
		} else {
			$statusCode = 500;
		}
    } else {
			$statusCode = 404;
    }
	$rest = $this->rest( $statusCode );
    return $response->withJson( $rest->build() );
};

/**
 * Delete a row from ID
 *
 * @param $tableName Required route parameter for table name.
 * @param $id Required route parameter ID of the row to be deleted.
 */
$rt[ "delete" ] = function ( Request $request, Response $response, array $args )
{
    $db = $this->database;
    $tableName = $args[ "tableName" ];
	$id = $args[ "id" ];
	if ( empty( $id ) )
		return $response->withJson( $this->rest( 400 )->build() );

    $where = [ "id" => $id ];
    if ( $db->isTable( $tableName ) ) {
		$result = $db->delete( $tableName, $where );
		if ( $result !== false ) {
			$statusCode = 200;
		} else {
			$statusCode = 500;
		}
    } else {
		$statusCode = 404;
    }
	$rest = $this->rest( $statusCode );
    return $response->withJson( $rest->build() );
};

/**
 * Slim App Routes
 */
$app->get( "/{tableName}", $rt[ "readAll" ] );
$app->post( "/{tableName}", $rt[ "create" ] );
$app->get( "/{tableName}/{id}", $rt[ "read" ] );
$app->put( "/{tableName}/{id}", $rt[ "update" ] );
$app->delete( "/{tableName}/{id}", $rt[ "delete" ] );
