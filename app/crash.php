<?php include 'auth.php'; ?>
<?php include '_header.php'; ?>
<h2>Crash Test</h2>
<?php
$factor = $_GET['factor'] ?? 1;

if (!is_numeric($factor) || $factor == 0) {
    echo "<p style='color:red'>Input tidak valid.</p>";
} else {
    $result = 100 / $factor; 
    echo "100 / " . htmlspecialchars($factor, ENT_QUOTES, 'UTF-8') . " = " . htmlspecialchars($result, ENT_QUOTES, 'UTF-8');
}
?>
<?php include '_footer.php'; ?>

