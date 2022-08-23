<?php
$dbUserName = "root";
$dbPassword = "password";
$pdo = new PDO(
  "mysql:host=mysql; dbname=todo; charset=utf8", 
  $dbUserName, 
  $dbPassword
);

$id = $_GET['id'];
$sql = "SELECT * FROM categories WHERE id = :id";
$statement = $pdo->prepare($sql);
$statement->bindValue(':id', $id, PDO::PARAM_INT);
$statement->execute();
$category = $statement->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ja">
<body>
	<form action="edit_save.php" method="post">
  <input type="hidden" name="category_id" value="<?php echo $id; ?>" >
		<table align="center">
      <tr>
        <th>編集</th>
      </tr>
      <tr>
        <td><input type="text" name="name" value="<?php echo $category[0]['name']; ?>"></td>
        <td><button type="submit" name="button">編集</button></td>
      </tr>
		</table>
	</form>
</body>
</html> 