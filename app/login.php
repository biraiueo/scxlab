<?php
include 'auth.php';

class Profile {
    public $username;
    public $isAdmin = false;

    function __construct($u, $isAdmin = false) {
        $this->username = $u;
        $this->isAdmin = $isAdmin;
    }

    function __toString() {
        return "User: {$this->username}, Role: " . ($this->isAdmin ? "Admin" : "User");
    }
}

if ($_POST) {
    $u = $_POST['username'] ?? '';
    $p = $_POST['password'] ?? '';

    $stmt = $GLOBALS['PDO']->prepare("SELECT * FROM users WHERE username = :u LIMIT 1");
    $stmt->execute([':u' => $u]);
    $row = $stmt->fetch();

    if ($row && password_verify($p, $row['password'])) {
        $_SESSION['user'] = $row['username'];
        $_SESSION['role'] = $row['role'];

        $pObj = new Profile($row['username'], $row['role'] === 'admin');
        $_SESSION['profile'] = $pObj;

        header("Location: dashboard.php");
        exit;
    } else {
        $error = "Login failed.";
    }
}
?>
<?php include '_header.php'; ?>
<h2>Login</h2>
<?php if (!empty($error)) echo "<p style='color:red'>$error</p>"; ?>
<form method="post">
  <label>Username <input name="username" required></label>
  <label>Password <input type="password" name="password" required></label>
  <button type="submit">Login</button>
</form>
<?php include '_footer.php'; ?>