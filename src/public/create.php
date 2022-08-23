<?php
session_start();
$dbUserName = "root";
$dbPassword = "password";
$pdo = new PDO("mysql:host=mysql; dbname=todo; charset=utf8", $dbUserName, $dbPassword);
$sql = "SELECT * FROM categories";
$statement = $pdo->prepare($sql);
$statement->execute();
$categories = $statement->fetchAll(PDO::FETCH_ASSOC);

foreach ($categories as $data) {
  $catedory_data .= "<option value='". $data['id'];
  $catedory_data .= "'>". $data['name']. "</option>";
}
// var_dump($categories);
$user_id = $_SESSION['id'];
$contents = $_POST['contents'];
$category_id = $_POST['id'];
$deadline = $_POST['deadline'];
// var_dump($category_id);
// die();
if (isset($user_id) and isset($deadline)) {
  $dbUserName = 'root';
  $dbPassword = 'password';
  $pdo = new PDO(
      'mysql:host=mysql; dbname=todo; charset=utf8',
      $dbUserName,
      $dbPassword
  );

  $sql = "INSERT INTO blogs(user_id, contents, category_id, deadline) VALUES (:user_id, :contents, :category_id, :deadline)";

  $statement = $pdo->prepare($sql);
  $statement->bindValue(':user_id', $user_id, PDO::PARAM_STR);
  $statement->bindValue(':contents', $contents, PDO::PARAM_STR);
  $statement->bindValue(':category_id', $category_id, PDO::PARAM_STR);
  $statement->bindValue(':deadline', $deadline, PDO::PARAM_STR);
  $statement->execute();
  header("Location: ./index.php");
  exit();
}
?>
<!DOCTYPE html>
<html lang="ja">

<style>
  .table {
    height: 100vh;
    display: grid;
    place-items: center;
  }
</style>
<body>
  <form action="create.php" method="post">
    <table align="center">
      <tr>
        <td><p><a href="category/index.php">カテゴリを追加</p></td>
      </tr>

      <tr>
        <td>
          <select name='category'>
            <?php 
              echo $catedory_data; 
            ?>
          </select>
        </td>
      </tr>

      <tr>
        <td><p><input type="text" name="contents" placeholder="タスクを追加"></p></td>
        <td><p><input type="date" name="deadline" placeholder=""></td>
        <td><p><a href="create.php">追加</p></td>
      </tr>

      <tr>
        <td><a href="index.php">戻る</td>
      </tr>
    </table>
  </from>
</body>
</html>