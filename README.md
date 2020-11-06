# PHP CRUD REST API
A generic CRUD REST API in modern PHP.

## Table of Contents
- [Support](https://github.com/enriquerene/php-crud-rest-api#support)
- [Installation](https://github.com/enriquerene/php-crud-rest-api#installation)
- [Configuration](https://github.com/enriquerene/php-crud-rest-api#configuration)
- [Usage](https://github.com/enriquerene/php-crud-rest-api#usage)
	+ [Create Record](https://github.com/enriquerene/php-crud-rest-api#create-record)
	+ [Read Records](https://github.com/enriquerene/php-crud-rest-api#read-records)
	+ [Update Record](https://github.com/enriquerene/php-crud-rest-api#update-record)
	+ [Delete Record](https://github.com/enriquerene/php-crud-rest-api#delete-record)
- [Plan](https://github.com/enriquerene/php-crud-rest-api#plan)
- [Contribute](https://github.com/enriquerene/php-crud-rest-api#contribute)

## <a name="support"></a> Support
If you need some help you can open an issue or get in touch by email ([contato@enriquerene.com.br](mailto:contato@enriquerene.com.br)).

## <a name="installation"></a> Installation
There are some installation ways. You can choose the best way for you.

### Git
Clone the repo into your project:
```bash
$ git clone https://github.com/enriquerene/php-crud-rest-api.git
```
Install dependencies:
```bash
$ composer install
```

### Zip
Dowload the package and uncpack it into your project: [Dowload ZIP](https://github.com/enriquerene/php-crud-rest-api/archive/main.zip). Run `composer install` into unpacked directory to install dependencies.

## <a name="configuration"></a> Configuration
Before use PHP CRUD REST API you must set up database connection. Edit `src/settings.php` as following example:
```php
<?php
$database = [
	"host" => "database_host",
	"name" => "database_name",
	"charset" => "utf8",
	"user" => "database_username",
	"password" => "database_user_pass",
	"prefix" => "tb_",
	"tables" => [
		"cars" => [
			"prefix" => "car_",
			"primary" => "id",
			/* "unique" => [ "model" ], */
			/* "default" => [ "year" => "2020" ], */
			"fields" => [
				"id" => "int(11)",
				"model" => "varchar(30)",
				"brand" => "varchar(30)",
				"year" => "char(4)"
			]
		]
	]
];
```

## <a name="usage"></a> Usage
You can make use of any HTTP client, but here we make use of [curl](). If you would like some usage example with other clients, send your suggestion to email address in [support section](https://github.com/enriquerene/php-crud-rest-api#support).
Let's start the PHP Built-in server:
```bash
$ php -S localhost:8080 -t path-to/php-crud-rest-api/public
```

### <a name="create-record"></a> Create Record
Send a POST request to `/tableName` route to create a new record. The application will accept JSON request body, so we need to set up headers properly:
```bash
$ curl --header 'application/json' --data '{"model":"Onix","brand":"Chevrolet","year":"2010"}' -X POST http://localhost:8080/cars
```

### <a name="read-records"></a> Read Records
Send a GET request to `/tableName` route to read records:
```bash
$ curl http://localhost:8080/cars
```
Get just what you need, nothing more:
```bash
$ curl http://localhost:8080/cars?fields=id,year
```
It's possible paginate the results:
```bash
$ curl http://localhost:8080/cars?perPage=10&page=1
```
Query a subset of all records where some condition happens:
```bash
$ curl http://localhost:8080/cars?brand=chevrolet
```
Read only one record:
```bash
$ curl http://localhost:8080/cars/1
```

### <a name="update-record"></a> Update Record
Send a PUT request to `/tableName/id` route to update a existing record. The application will accept JSON request body, so we need to set up headers properly. Send in body just what you want to update:
```bash
$ curl --header 'application/json' --data '{"year":"2011"}' -X PUT http://localhost:8080/cars/1
```

### <a name="delete-record"></a> Delete Record
Send a DELETE request to `/tableName/id` route to delete a existing record:
```bash
$ curl -X DELETE http://localhost:8080/cars/1
```

## <a name="plan"></a> Plan
There are some items thought for future versions of PHP CRUD REST API:
1. Basic Authentication Layer;
1. JSON Web Token Authentication Layer;
1. Email Service Layer;
1. Publish at Packagist.

## <a name="contribute"></a> Contribute
Do a pull request or send email to Support.
