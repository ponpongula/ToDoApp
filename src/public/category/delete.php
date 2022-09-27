<?php 
$dbUserName = "root";
$dbPassword = "password";
$options = [];
$pdo = new PDO(
  "mysql:host=mysql; dbname=todo; charset=utf8", 
  $dbUserName, 
  $dbPassword,
  $options
);
$id = filter_input(INPUT_POST, 'id');

try{
	$sql = "DELETE FROM tasks WHERE id = :id";
	$stmt = $pdo->prepare($sql);
	$stmt->bindParam(':id', $id);
	$stmt->execute();
  header("Location: index.php");
} catch (PDOException $e) {
	echo 'Error: ' . $e->getMessage();
	die();
}
?>