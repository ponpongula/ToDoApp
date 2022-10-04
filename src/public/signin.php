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
  <form action="signin_save.php" method="post">
    <table align="center">
      <tr>
        <td><h2>ログインページ</h2></td>
      </tr>

      <tr>
        <td><input type="text" name="email" placeholder="Eメール"></td>
      </tr>

      <tr>
        <td><input type="password" name="password" placeholder="パスワード"></td>
      </tr>

      <tr>
        <td><input type="submit" value="ログイン"></td>
      </tr>

      <tr>
        <td><a href="signup.php">アカウントを作る</td>
      </tr>

    </table>
  </from>
</body>
</html>