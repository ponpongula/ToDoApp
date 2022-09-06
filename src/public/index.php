<?php
session_start();
$search_word = filter_input(INPUT_GET, 'search');
$user_id = $_SESSION['id'];
var_dump($user_id);
$dbUserName = "root";
$dbPassword = "password";
$pdo = new PDO(
  "mysql:host=mysql; dbname=todo; charset=utf8", 
  $dbUserName, 
  $dbPassword
);

require_once("./header.php");
$sql = "SELECT * FROM tasks JOIN categories ON tasks.category_id = categories.id WHERE contents LIKE '%" . $search_word . "%' OR name LIKE '%" . $search_word . "%' ORDER BY created_at";
$statement = $pdo->prepare($sql);
$statement->execute();
$tasks = $statement->fetchAll(PDO::FETCH_ASSOC);
var_dump($tasks);
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
        <label>
          <input type="radio" name="order" value="desc" class="" 
          <?php if (
            isset($_GET['order']) || $_GET['order'] == 'desc') {
                  echo 'checked';
              } ?>>
          <span>新着順</span>
        </label>
        <label>
          <input type="radio" name="order" value="asc" class="" 
          <?php if (isset($_GET['order']) && $_GET['order'] != 'desc') {
                    echo 'checked';
                } ?>>
          <span>古い順</span>
        </label>
      </td>
    </tr>
    </form>
  </table>

  <th><a href = "create.php">タスクを追加</a></th>

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
        <input type="hidden" name ="id" value = "<?php echo $value['id']; ?>"></input>
        <tr>
            <td><?php echo $value['contents']; ?></td>
            <td><?php echo $value['deadline']; ?></td>
            <td><?php echo $value['name']; ?></td>
            <td>
            <?php 
            if (0 == $value['status']) {
              echo "未完了";
            } else {
              echo "完了";
            } 
            ?>
            </td>
            <td><a href = "edit.php?id=<?php echo $value['id']; ?>">編集</td>    
            <td><a href = "delete.php?id=<?php echo $value['id']; ?>">削除</td>  
        </tr>
      </form>
    <?php endforeach; ?>
  </table>
</body>
</html>