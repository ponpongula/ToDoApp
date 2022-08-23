<?php
 session_start();
$email = $_POST['email'];
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
  <form action="signin.php" method="post">
    <table align="center">
      <tr>
        <td><h2>ログインページ</h2></td>
      </tr>

      <tr>
        <td><p><input type="text" name="email" placeholder="Eメール"></p></td>
      </tr>

      <tr>
        <td><p><input type="password" name="password" placeholder="パスワード"></p></td>
      </tr>

      <tr>
        <td><p><input type="submit" value="ログイン"></p></td>
      </tr>

      <tr>
        <td><p><a href="signup.php">アカウントを作る</p></td>
      </tr>

    </table>
  </from>
</body>
</html>