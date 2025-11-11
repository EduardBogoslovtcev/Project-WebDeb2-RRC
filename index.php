<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link rel="stylesheet" href="styles.css?v=<?php echo time(); ?>">
</head>
<body>
    <form action="login_action.php" method="POST" class="form-box active" id="login_form">
      <h2>Login</h2>
      <input type="email" name="email" placeholder="Email" required />
      <input type="password" name="password" placeholder="Password" required />
      <button type="submit" name="login">Login</button>
      <p>Don't have an account yet? <a href="#" onclick="showForm('register_form')">Register</a></p>
    </form>

    <form action="register_action.php" method="POST" class="form-box" id="register_form">
      <h2>Register</h2>
      <input type="text" name="username" placeholder="Username" required />
      <input type="email" name="email" placeholder="Email" required />
      <input type="password" name="password" placeholder="Password" required />
      <input type="password" name="password" placeholder="Repeat password" required />
      <button type="submit" name="Register">Register</button>
      <p>Already have an account? <a href="#" onclick="showForm('login_form')">Login</a></p>
    </form>

    <script src="showForm.js"></script>
</body>
</html>
