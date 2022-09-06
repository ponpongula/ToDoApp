<?php
session_start();
$dbUserName = "root";
$dbPassword = "password";
$pdo = new PDO(
  "mysql:host=mysql; dbname=todo; charset=utf8", 
  $dbUserName, 
  $dbPassword
);

$task_id = filter_input(INPUT_POST, 'task_id');
$user_id = $_SESSION['id'];
$status = 0;
$content = filter_input(INPUT_POST, 'contents');
$category_id = filter_input(INPUT_POST, 'category');
$deadline = filter_input(INPUT_POST, 'deadline');
$stmt = $pdo->prepare("UPDATE tasks SET user_id = :user_id, status = :status, contents = :contents, category_id = :category_id, deadline = :deadline WHERE id = :id");
$stmt->bindParam(':id', $task_id, PDO::PARAM_INT);
$stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$stmt->bindParam(':status', $status, PDO::PARAM_INT);
$stmt->bindParam(':contents', $content, PDO::PARAM_STR);
$stmt->bindParam(':category_id', $category_id, PDO::PARAM_INT);
$stmt->bindParam(':deadline', $deadline, PDO::PARAM_STR);
$stmt->execute();
header("Location: index.php");
exit();
?>