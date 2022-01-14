<?php
	$server = "127.0.0.1";
	$username = "root";
	$password = "";
	$db = "eonix";
	$port = 3307;


	// Souvent on identifie cet objet par la variable $conn ou $db
	$mysqlClient = new PDO(
		'mysql:host='.$server.';port='.$port.';dbname='.$db.';charset=utf8',
		$username,
		$password
	);
?>