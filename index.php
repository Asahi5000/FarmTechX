<?php
session_start();
echo "VERSION 2";

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>FarmTechX Login</title>
  <link rel="stylesheet" href="assets/css/index-styles1.css" />
  <link rel="icon" href="assets/images/FarmTechX.jpg" />
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
  <div class="login-container">
    <img src="/assets/images/company-logo.jpg" alt="FarmTechX Logo" class="logo" />
    <h2>FarmTechX Login</h2>
    <form action="login.php" method="post">
      <div class="input-group">
        <input type="text" name="username" placeholder="Username" required>
        <i class='bx bx-user'></i>
      </div>

      <div class="input-group">
        <input type="password" name="password" placeholder="password" required>
        <i class='bx bx-lock-alt'></i>
      </div>

      <div class="forgot-password">
        <!-- <a href="#">Forgot Password?</a> -->
      </div>  

      <button type="submit" class="btn-login">Login</button>
    </form>
  </div>
</body>
</html>
