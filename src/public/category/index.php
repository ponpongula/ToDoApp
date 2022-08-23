<?php
session_start();
$dbUserName = "root";
$dbPassword = "password";
$pdo = new PDO(
  "mysql:host=mysql; dbname=todo; charset=utf8", 
  $dbUserName, 
  $dbPassword
);
if (empty($_SESSION['id'])){
  header("Location: /signin.php");
}
$sql = "SELECT * FROM categories";
$statement = $pdo->prepare($sql);
$statement->execute();
$categorys = $statement->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ja">

<style>
  .table {
    height: 100vh;
    display: grid;
    place-items: center;
    border:double 2px #2196f3;
  }
</style>
<body>
  <form action="store.php" method="post">
    <table align="center">
      <tr>
        <th>カテゴリ一覧</th>
      <tr>

      <tr>
        <td><input type="text" name="name" placeholder="カテゴリを追加"></td>
        <td><button type="submit" name="button">登録</button></td>
      </tr>

      <?php foreach ($categorys as $category) : ?>
      <tr>
        <td><?php echo $category['name'] ?></td>
        <td><a href = "edit.php?id=<?php echo $category['id']; ?>">編集</td>    
        <td><a href = "delete.php?id=<?php echo $category['id']; ?>">削除</td>
      </tr>
      <?php endforeach; ?>

      <tr>
        <td><a href = "/create.php">戻る</td> 
      </tr>
    </table>
  </from>
</body>
</html>