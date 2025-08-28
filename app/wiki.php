<?php include 'auth.php'; ?>
<?php include '_header.php'; ?>
<h2>Wiki Search</h2>
<form method="get">
  <input name="q" placeholder="Search...">
  <button>Search</button>
</form>

<?php
if (isset($_GET['q'])) {
    $q = $_GET['q'];

    // gunakan prepared statement untuk mencegah SQL Injection
    $stmt = $GLOBALS['PDO']->prepare("SELECT * FROM articles WHERE title LIKE ?");
    $stmt->execute(["%$q%"]);

    // tampilkan query yang aman (di-escape) → mencegah XSS
    echo "<p>Query: " . htmlspecialchars($q, ENT_QUOTES, 'UTF-8') . "</p>";

    // tampilkan hasil dengan escape juga
    foreach ($stmt as $row) {
        $title = htmlspecialchars($row['title'], ENT_QUOTES, 'UTF-8');
        $body  = htmlspecialchars($row['body'], ENT_QUOTES, 'UTF-8');
        echo "<li>{$title}: {$body}</li>";
    }
}
?>
<?php include '_footer.php'; ?>
