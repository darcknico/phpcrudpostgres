<?php
	/*
	$user = "postgres";
	$password = "4272845";
	$dbname = "BD_VENTAS";
	$port = "5432";
	$host = "127.0.0.1";
	$user = "postgres";
	//$password = "4272845";
	//$dbname = "BD_VENTAS";
	$password = "1234";
	$dbname = "apipost";
	$port = "5432";
	$host = "127.0.0.1";
	*/

	//BASE DE DATOS EN LA NUBE
	$user = "bntskajq";
	$password = "x_eCtbyBO2AV8HYvhF1EreuSsgyqZPTU";
	$dbname = "bntskajq";
	$port = "5432";
	$host = "hard-plum.db.elephantsql.com";

	$cadenaConexion = "host=$host port=$port dbname=$dbname user=$user password=$password";

	$conexion = pg_connect($cadenaConexion) or die("Error en la Conexión: ".pg_last_error());
?>