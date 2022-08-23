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
if (isset($_GET['search'])) {
  $title = '%' . $_GET['search'] . '%';
  $content = '%' . $_GET['search'] . '%';
} else {
  $title = '%%';
  $content = '%%';
}
require_once("./header.php");
$sql = "SELECT * FROM tasks WHERE title LIKE :title OR content LIKE :content ORDER BY id $direction";
$statement = $pdo->prepare($sql);
$statement->bindValue(':title', $title, PDO::PARAM_STR);
$statement->bindValue(':content', $content, PDO::PARAM_STR);
$statement->execute();
$tasks = $statement->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ja">
<head>
 <title>メモ一覧</title>
</head>

<body>
  <table border="1" align="center" width="750">
    <form action="index.php" method="get">
    <tr>
      <td>
        <input name="search" type="text" value="<?php echo $_GET['search'] ??''; ?>" placeholder="キーワードを入力">
        <input type="submit" name="submit" value="検索">
      </td>
    </tr>
    </form>
  </table>
  <th><a href = "create.php"><p>タスクを追加</p></a></th>
  <table border="1" align="center" width="1500">
    <tr>
      <th>タスク名</th>
      <th>締め切り</th>
      <th>カテゴリー名</th>
      <th>完了・未完了</th>
      <th>編集</th>
      <th>削除</th>
    </tr>
    <?php foreach ($tasks as $value) : ?>
      <form action ="index.php" method="post">
        <input type="hidden" name ="id" value = "<?php echo $value['id']  ?>"></input>
        <tr>
            <td><p><?php echo $value['title']  ?></p></td>
            <td><p><?php echo $value['content'] ?></p></td>
            <td><p><?php echo $value['created_at'] ?></p></td>
            <td><p><a href = "edit.php?id=<?php echo $value['id']; ?>">編集</p></td>    
            <td><p><a href = "delete.php?id=<?php echo $value['id']; ?>">削除</p></td>  
        </tr>
        </form>
    <?php endforeach; ?>
  </table>
</body>
</html>