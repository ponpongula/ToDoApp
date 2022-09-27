<?php
$dbUserName = "root";
$dbPassword = "password";
$pdo = new PDO(
  "mysql:host=mysql; dbname=todo; charset=utf8", 
  $dbUserName, 
  $dbPassword
);
$id = filter_input(INPUT_GET, 'id');
$status = filter_input(INPUT_GET, 'status');
if (0 == $status) {
  ++$status;
} else {
  unset($status);
  $status = 0;
}
$stmt = $pdo->prepare("UPDATE tasks SET status = :status WHERE id = :id");
$stmt->bindValue(':id', $id, PDO::PARAM_STR);
$stmt->bindValue(':status', $status, PDO::PARAM_STR);
$stmt->execute();
header("Location: index.php");
exit();
?>