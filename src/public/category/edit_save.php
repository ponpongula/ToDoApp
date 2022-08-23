<?php
$dbUserName = "root";
$dbPassword = "password";
$pdo = new PDO(
  "mysql:host=mysql; dbname=todo; charset=utf8", 
  $dbUserName, 
  $dbPassword
);

$id = $_POST["category_id"];
$name = $_POST["name"];
$stmt = $pdo->prepare("UPDATE categories SET name = :name WHERE id = :id");
$stmt->bindParam(':id', $id, PDO::PARAM_INT);
$stmt->bindParam(':name', $name, PDO::PARAM_STR);
$stmt->execute();
header("Location: index.php");
exit();
?>