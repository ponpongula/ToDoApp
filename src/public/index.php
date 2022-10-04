<?php
session_start();
$search_word = filter_input(INPUT_GET, 'search');
$search_category = filter_input(INPUT_GET, 'category');
$search_completion = filter_input(INPUT_GET, 'completion');
var_dump($search_word);var_dump($search_category);var_dump($search_completion);
$user_id = $_SESSION['id'];
$dbUserName = "root";
$dbPassword = "password";
$pdo = new PDO(
  "mysql:host=mysql; dbname=todo; charset=utf8", 
  $dbUserName, 
  $dbPassword
);

require_once("./header.php");

// if (isset($_GET['order'])) {
//   $direction = $_GET['order'];
// } else {
//   $direction = 'desc';
// } 
if (isset($search_word) OR isset($search_category) OR isset($search_completion)) {
  $sql = "SELECT 
  tasks.contents
  , tasks.id AS tasks_id
  , tasks.deadline
  , categories.name AS category_name
  , tasks.category_id AS category_id
  , tasks.status 
  FROM 
    tasks 
  JOIN categories 
    ON tasks.category_id = categories.id 
    WHERE contents LIKE :search_word 
    OR category_id = :search_category
    ORDER BY tasks_id";
} else {
  $sql = "SELECT 
  tasks.contents
  , tasks.id AS tasks_id
  , tasks.deadline
  , categories.name AS category_name
  , tasks.category_id AS category_id
  , tasks.status
  FROM 
    tasks 
  JOIN categories 
    ON tasks.category_id = categories.id";
}
var_dump($sql);
if ($_GET['order'] === 'desc') {
  $sql = $sql . ' DESC';
} elseif ($_GET['order'] === 'asc') {
  $sql = $sql . ' ASC';
}
$statement = $pdo->prepare($sql);
$statement->bindValue(":search_word", '%' . $search_word . '%', PDO::PARAM_STR);
$statement->bindValue(':search_category', '%' . $search_category . '%', PDO::PARAM_INT);
$statement->execute();
$tasks = $statement->fetchAll(PDO::FETCH_ASSOC);

$sql = "SELECT * FROM categories";
$statement = $pdo->prepare($sql);
$statement->execute();
$categories = $statement->fetchAll(PDO::FETCH_ASSOC);
print_r($tasks);
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
          <?php if (!isset($_GET['order']) || $_GET['order'] == 'desc') {
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

        <select name='category'>
          <?php foreach ($categories as $data): ?>
            <option type="data" value=<?php echo $data['id'];?>><?php echo $data['name'];?></option>
          <?php endforeach; ?>
        </select>

        <label>
          <input type="radio" name="completion" value="0" class="">
          <span>完了</span>
        </label>
        <label>
          <input type="radio" name="completion" value="1" class="">
          <span>未完了</span>
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
        <input type="hidden" name ="id" value ="<?php echo $value['tasks_id']; ?>"></input>
        <tr>
            <td><?php echo $value['contents']; ?></td>
            <td><?php echo $value['deadline']; ?></td>
            <td><?php echo $value['category_name']; ?></td>
            <td>
            <?php if (0 == $value['status']) : ?>
              <a href = "updateStatus.php?id=<?php echo $value['tasks_id'];?>&status=<?php echo $value['status']; ?>">未完了</a>
            <?php else : ?>
              <a href = "updateStatus.php?id=<?php echo $value['tasks_id'];?>&status=<?php echo $value['status']; ?>">完了</a>
            <?php endif; ?>
       
            </td>
            <td><a href = "edit.php?id=<?php echo $value['tasks_id']; ?>">編集</td>    
            <td><a href = "delete.php?id=<?php echo $value['tasks_id']; ?>">削除</td>  
        </tr>
      </form>
    <?php endforeach; ?>
  </table>
</body>
</html>