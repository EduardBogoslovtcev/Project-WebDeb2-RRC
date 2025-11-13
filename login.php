<?php 

$success_message = '';

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link rel="stylesheet" href="styles.css?v=<?php echo time(); ?>">
</head>
<body>
    <?php if ($success_message): ?>
      <div class="success-banner"><?php echo htmlspecialchars($success_message); ?></div>
    <?php endif; ?>
    
    <form action="auth.php" method="POST" class="form-box" id="login_form">
      <h2>Login</h2>
      <input type="text" name="username" placeholder="Username" required />
      <input type="password" name="password" placeholder="Password" required />
      <button type="submit" name="login">Login</button>
      
      <div class="stay-logged-in">
        <input type="checkbox" name="logged_in" id="logged-in">
        <label for="logged-in" >Stay logged in</label>
      </div>

      <p>Don't have an account yet? <a href="register.php">Register</a></p>
    </form>
</body>
</html>