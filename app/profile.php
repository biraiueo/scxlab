<?php
include 'auth.php';

class Profile {
    public $username;
    public $isAdmin = false;

    function __toString() {
        return "User: {$this->username}, Role: " . ($this->isAdmin ? "Admin" : "User");
    }
}

if (!isset($_SESSION['user']) || !isset($_SESSION['role'])) {
    die("Session tidak ditemukan. Silakan login ulang.");
}

$profile = new Profile($_SESSION['user'], $_SESSION['role'] === 'admin');

if ($profile->isAdmin && isset($_POST['delete_user'])) {
    $target = $_POST['delete_user'];

    $stmt = $GLOBALS['PDO']->prepare("DELETE FROM users WHERE username = ?");
    $stmt->execute([$target]);

    $msg = "<p style='color:green'>User <b>" . htmlspecialchars($target, ENT_QUOTES, 'UTF-8') . "</b> berhasil dihapus!</p>";
}

include '_header.php';
?>
<h2>Profile Page</h2>
<p><?php echo $profile; ?></p>

<?php if ($profile->isAdmin): ?>
  <h3>Admin Panel</h3>
  <form method="post">
    <label>Delete user:
      <select name="delete_user">
        <?php
        $users = $GLOBALS['PDO']->query("SELECT username FROM users");
        foreach ($users as $u) {
            if ($u['username'] !== $profile->username) {
                // escape untuk mencegah XSS
                $uname = htmlspecialchars($u['username'], ENT_QUOTES, 'UTF-8');
                echo "<option value='{$uname}'>{$uname}</option>";
            }
        }
        ?>
      </select>
    </label>
    <button type="submit">Delete</button>
  </form>
  <?php if (!empty($msg)) echo $msg; ?>
<?php else: ?>
  <p style="color:red">You are a regular user. You do not have admin panel access.</p>
<?php endif; ?>

<?php include '_footer.php'; ?>

