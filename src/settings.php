<?php

$database = [
	"host" => "localhost",
	"name" => "restapi",
	"charset" => "utf8",
	"user" => "restapi",
	"password" => "restpass",
	"prefix" => "tb_",
	"tables" => [
		"cars" => [
			"prefix" => "car_",
			"primary" => "id",
			"fields" => [
				"id" => "int(11)",
				"model" => "varchar(30)",
				"brand" => "varchar(30)",
				"year" => "char(4)"
			]
		]
	]
];

return [
    "settings" => [
        "displayErrorDetails" => true,
        "addContentLengthHeader" => true,
        "database" => $database
    ]
];
