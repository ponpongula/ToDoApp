<?php
$name = filter_input(INPUT_POST, 'name');
$email = filter_input(INPUT_POST, 'email');
$password = filter_input(INPUT_POST, 'password');
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
  var_dump($member);
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
    echo '<a href="signin.php">戻る</a>';
  }
}

?>