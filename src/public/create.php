<?php
session_start();
$dbUserName = "root";
$dbPassword = "password";
$pdo = new PDO("mysql:host=mysql; dbname=todo; charset=utf8", $dbUserName, $dbPassword);
$sql = "SELECT * FROM categories";
$statement = $pdo->prepare($sql);
$statement->execute();
$categories = $statement->fetchAll(PDO::FETCH_ASSOC);
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
  <form action="store.php" method="post">
    <table align="center">
      <tr>
        <td><p><a href="category/index.php">カテゴリを追加</p></td>
      </tr>

      <tr>
        <td>
          <select name='category'>
            <?php foreach ($categories as $data): ?>
              <option type="data" value=<?php echo $data['id'];?>><?php echo $data['name'];?></option>
            <?php endforeach; ?>
          </select>
        </td>
      </tr>

      <tr>
        <td><input type="text" name="contents" placeholder="タスクを追加"></td>
        <td><input type="date" name="deadline" placeholder=""></td>
        <td><button>追加</button></td>
      </tr>

      <tr>
        <td><a href="index.php">戻る</td>
      </tr>
    </table>
  </from>
</body>
</html>