<?php
session_start();
$name = $_POST['name'];
$user_id = $_SESSION['id'];
if (empty($user_id)) {
  header("Location: public/signin.php");
  exit();
}

if (isset($name) and isset($user_id)) {
  $dbUserName = 'root';
  $dbPassword = 'password';
  $pdo = new PDO(
      'mysql:host=mysql; dbname=todo; charset=utf8',
      $dbUserName,
      $dbPassword
  );

  $sql = "INSERT INTO categories(name, user_id) VALUES (:name, :user_id)";

  $statement = $pdo->prepare($sql);
  $statement->bindValue(':name', $name, PDO::PARAM_STR);
  $statement->bindValue(':user_id', $user_id, PDO::PARAM_STR);
  $statement->execute();
  header("Location: index.php");
  exit();
} else {
  echo "記入漏れがあります";
  echo '<a href="create.php">戻る</a>';
}
?>