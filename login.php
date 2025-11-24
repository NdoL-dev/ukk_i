<?php
  session_start();
  include ('database.php');

  if(isset($_POST['login'])){
    $username = $_POST['username'];
    $password_input = $_POST['password'];

    $query = mysqli_query ($conn, "SELECT * FROM users WHERE username='$username'");
    $data = mysqli_fetch_assoc ($query);

    if ($data){

      if (password_verify($password_input, $data ['password'])){
        $_SESSION ['username'] = $data ['username'];
        $_SESSION ['fullname'] = $data ['fullname'];
        $_SESSION ['login'] = true;

        header ("location: dashboard.php");
        exit;

      }else {
        $error = "Password salah";
      }
    }else {
      $error = "Username salah";
    }
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login | Inventaris</title>
  <link rel="stylesheet" href="assets/style.css">
</head>
<body>
  <div class="container">
    <form method="post" action="">
      <div class="logo">
        <img src="img/user-icon.png" alt="User Icon">
      </div>
      <h2>Login</h2>
      <input type="text" name="username" placeholder="Masukkan Username" require><br>
      <input type="password" name="password" placeholder="Masukkan Password" require><br>
      <input type="submit" name="login" value="LOGIN">
    </form>
    <?php if (isset($error))echo "<p style='color:red'>$error</p>"; ?>
</body>
</html>