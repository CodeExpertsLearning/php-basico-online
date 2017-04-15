<?php 

function connection()
{
	$dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME;
	
	$pdo = new \PDO($dsn, DB_USER, DB_PASSWORD);

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    return $pdo;
}