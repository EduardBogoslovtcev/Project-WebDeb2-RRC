<?php 
session_start();
require('db_connect.php');

$errors = [
  'username' => '',
  'email' => '',
  'password' => '',
  'password_repeat' => '', 
  'role' => ''
];
$success_message = '';

// default form shown

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["register"])) {

  // sanitize inputs
  $username = trim(filter_var($_POST['username'], FILTER_SANITIZE_FULL_SPECIAL_CHARS));
  $email = trim(filter_var($_POST['email'], FILTER_SANITIZE_EMAIL));
  $password = $_POST['password']; 
  $password_repeat = $_POST['password_repeat'];
  $role = $_POST['role'];

  // --- Validation ---
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $errors['email'] = 'Enter a valid email address.';
  }

  if (!preg_match('/^(?=.*[A-Z])(?=.*\d).{15,}$/', $password)) {
      $errors['password'] = 'Must be 15+ chars, 1 uppercase, 1 number.';
  }

  if ($password !== $password_repeat) {
      $errors['password_repeat'] = 'Passwords do not match.';
  }

    // check duplicates only if previous fields are OK
  if (!array_filter($errors)) {
      $check_user = $db->prepare("SELECT * FROM users_cms WHERE email = :email OR username = :username");
      $check_user->execute([':email' => $email, ':username' => $username]);
      if ($check_user->rowCount() > 0) {
          $errors['email'] = 'Username or email already exists.';
      }
  }

  // if no errors, insert
  if (!array_filter($errors)) {
      $hashed_password = password_hash($password, PASSWORD_DEFAULT);
      $insert_user = $db->prepare("INSERT INTO users_cms (username, email, password, role)
                                     VALUES (:username, :email, :password, :role)");
      $insert_user->execute([
          ':username' => $username,
          ':email' => $email,
          ':password' => $hashed_password,
          ':role' => $role
      ]);

      $success_message = 'Registration successful! You can now log in.';
      // clear form fields
      $username = $email = $password = $password_repeat = '';
  }

}
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

    <form action="register.php" method="POST" class="form-box" id="register_form">
      <h2>Register</h2>
      
      <input type="text" name="username" placeholder="Username" value="<?php echo isset($username) ? htmlspecialchars($username) : ''; ?>" required />

      <input type="email" name="email" placeholder="Email"  value="<?php echo isset($email) ? htmlspecialchars($email) : ''; ?>" required />

      <input type="password" name="password" placeholder="Password"  value="<?php echo isset($password) ? htmlspecialchars($password) : ''; ?>" required />
      
      <small class="password-hint">
        Password must be at least 15 characters long, include one uppercase letter, and one number.
      </small>
      
      <input type="password" name="password_repeat" placeholder="Repeat password" value="<?php echo isset($password_repeat) ? htmlspecialchars($password_repeat) : ''; ?>" required />

      <select name="role" id="role" required>
        <option value="">--Select Role--</option>
        <option value="admin">Admin</option>
        <option value="user">User</option>
      </select>

      <button type="submit" name="register">Register</button>

      <p>Already have an account? <a href="login.php">Login</a></p>
    </form>
</body>
</html>
