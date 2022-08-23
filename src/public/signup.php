<?php
$name = $_POST['name'];
$email = $_POST['email'];
$password = $_POST['password'];

if (empty($name) && empty($email) && empty($password)) {
  echo '「ユーザーネーム」「Email」「パスワード」を入力してください';
} else {
  $password2 = $_POST['password2'];

  if (empty($password) || empty($password2)) {
    echo "<font color='#f00'>パスワードが入力されていません</font>";
  } elseif ($password !== $password2) {
    echo "<font color='#f00'>パスワードが一致しません</font>";
    header("Location: singnup.php");
    exit;
  }
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
  if ($member['email'] === $email) {
    echo "<font color='#f00'>メールアドレスが複重しています</font>";
    echo '<a href="signup.php">戻る</a>';
  } else {
    $sql = "INSERT INTO users (name, email, password) VALUES (:name, :email, :password)";
    $statement = $pdo->prepare($sql);
    $statement->bindValue(':name', $name, PDO::PARAM_STR);
    $statement->bindValue(':email', $email, PDO::PARAM_STR);
    $statement->bindValue(':password', $password, PDO::PARAM_STR);
    $statement->execute();
    print"<font color='#f00'>登録が完了しました</font>";
    echo '<a href="index.php">戻る</a>';
  }
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
  <form action="signup.php" method="post">
    <table align="center">
      <tr>
        <td><h2>新規会員登録</h2>
      </tr>

      <tr>
        <td><p><input type="text" name="name" placeholder="ユーザーネーム"></p></td>
      </tr>

      <tr>
        <td><p><input type="text" name="email" placeholder="Eメール"></p></td>
      </tr>

      <tr>
        <td><p><input type="password" name="password" placeholder="パスワード"></p></td>
      </tr>

      <tr>
        <td><p><input type="password" name="password2" placeholder="パスワード確認"></p></td>
      </tr>

      <tr>
        <td><p><input type="submit" value="登録"></p></td>
      </tr>

      <tr>
        <td><p><a href="index.php">ログイン画面へ</p></td>
      </tr>
    </table>
  </from>
</body>
</html>