<?php
$dbUserName = "root";
$dbPassword = "password";
$pdo = new PDO(
  "mysql:host=mysql; dbname=todo; charset=utf8", 
  $dbUserName, 
  $dbPassword
);

$id = filter_input(INPUT_GET, 'id');

$sql = "SELECT * FROM tasks WHERE id = :id";
$statement = $pdo->prepare($sql);
$statement->bindParam(':id', $id);
$statement->execute();
$tasks = $statement->fetchAll(PDO::FETCH_ASSOC);

$sql = "SELECT * FROM categories";
$statement = $pdo->prepare($sql);
$statement->execute();
$category = $statement->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ja">
<body>
	<form action="update.php" method="post">
  <input type="hidden" name="task_id" value="<?php echo $id; ?>" >
    <table align="center">

      <tr>
        <td>
          <select name='category'>
            <?php foreach ($category as $data): ?>
              <option type="data" value=<?php echo $data['id'];?>><?php echo $data['name'];?></option>
            <?php endforeach; ?>
          </select>
        </td>
      </tr>

      <tr>
        <td><input type="text" name="contents" placeholder="タスクを追加" value=<?php echo $tasks[0]['contents'];?>></td>
        <td><input type="date" name="deadline" value=<?php echo $tasks[0]['deadline'];?>></td>
        <td><button>変更</button></td>
      </tr>

      <tr>
        <td><a href="index.php">戻る</td>
      </tr>
    </table>
  </from>
</body>
</html>