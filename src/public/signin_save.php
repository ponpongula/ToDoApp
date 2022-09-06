<?php
 session_start();
$email = filter_input(INPUT_POST, 'email');
$dbUserName = 'root';
$dbPassword = 'password';
$pdo = new PDO(
    'mysql:host=mysql; dbname=todo; charset=utf8',
    $dbUserName,
    $dbPassword
);

$sql = "SELECT * FROM users WHERE email = :email";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':email', $email);
$stmt->execute();
$member = $stmt->fetch();
if (empty($_POST['email']) && empty($_POST['password'])) {
  echo "Eメールとパスワードを入力してください";
} elseif ($_POST['password'] === $member['password']) {
  $_SESSION['id'] = $member['id'];
  $_SESSION['name'] = $member['name'];
  header("Location: ./index.php");
  exit();
} else {
  echo 'メールアドレスもしくはパスワードが間違っています。';
  echo '<a href="signin.php">戻る</a>';
}
?>