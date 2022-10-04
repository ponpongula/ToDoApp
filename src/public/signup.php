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
  <form action="signup_save.php" method="post">
    <table align="center">
      <tr>
        <td><h2>新規会員登録</h2>
      </tr>

      <tr>
        <td><input type="text" name="name" placeholder="ユーザーネーム"></td>
      </tr>

      <tr>
        <td><input type="text" name="email" placeholder="Eメール"></td>
      </tr>

      <tr>
        <td><input type="password" name="password" placeholder="パスワード"></td>
      </tr>

      <tr>
        <td><input type="password" name="password2" placeholder="パスワード確認"></td>
      </tr>

      <tr>
        <td><input type="submit" value="登録"></td>
      </tr>

      <tr>
        <td><a href="index.php">ログイン画面へ</td>
      </tr>
    </table>
  </from>
</body>
</html>