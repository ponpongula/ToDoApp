<?php
session_start();
$user_id = $_SESSION['id'];
$status = 0;
$contents = filter_input(INPUT_POST, 'contents');
$category_id = filter_input(INPUT_POST, 'category');
$deadline = filter_input(INPUT_POST, 'deadline');
if (isset($contents) and isset($category_id) and isset($deadline)) {
  $dbUserName = 'root';
  $dbPassword = 'password';
  $pdo = new PDO(
      'mysql:host=mysql; dbname=todo; charset=utf8',
      $dbUserName,
      $dbPassword
  );

  $sql = "INSERT INTO tasks(user_id, status, contents, category_id, deadline) VALUES (:user_id, :status, :contents, :category_id, :deadline)";
  $statement = $pdo->prepare($sql);
  $statement->bindValue(':user_id', $user_id, PDO::PARAM_STR);
  $statement->bindValue(':status', $status, PDO::PARAM_INT);
  $statement->bindValue(':contents', $contents, PDO::PARAM_STR);
  $statement->bindValue(':category_id', $category_id, PDO::PARAM_STR);
  $statement->bindValue(':deadline', $deadline, PDO::PARAM_STR);
  $statement->execute();
  header("Location: index.php");
  exit();
} else {
  echo "記入漏れがあります";
  echo '<a href="create.php">戻る</a>';
}
?>