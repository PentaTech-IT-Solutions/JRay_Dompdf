<?php 
$host = 'mysql:host=localhost;dbname=penta';
$user = 'root';
$password = '';

try {
	$pdo = new PDO($host, $user, $password);
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	//echo "DATABASE CONNECTED!";
} catch (Exception $e) {
	echo "Connection failed ".$e->getMessage();
}

 ?>