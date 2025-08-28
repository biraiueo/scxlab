<?php include 'auth.php'; ?>
<?php include '_header.php'; ?>
<h2>Ping Server</h2>
<form method="get">
  <input name="target" placeholder="IP address..." required>
  <button>Ping!</button>
</form>

<?php
if (isset($_GET['target'])) {
    $target = $_GET['target'];

    if (!filter_var($target, FILTER_VALIDATE_IP)) {
        die("Invalid IP address.");
    }

    $safeTarget = escapeshellarg($target);

    echo "<h3>Ping Result for: " . htmlspecialchars($target, ENT_QUOTES, 'UTF-8') . "</h3>";
    $output = shell_exec("ping -c 2 " . $safeTarget);
    echo "<pre>" . htmlspecialchars($output, ENT_QUOTES, 'UTF-8') . "</pre>";
}
?>
<?php include '_footer.php'; ?>





