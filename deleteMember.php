<?php 
@include("db_con.php");

if (isset($_GET['id'])) {
	$result = $pdo->prepare("DELETE FROM team WHERE id = ?");
	$result->execute(array($_GET['id']));
	$deleted = $result->execute(array($_GET['id']));
	if ($deleted) {
		 header('Location: dashboard.php');
		 } 
}
?>