<?php include 'auth.php'; ?>
<?php include '_header.php'; ?>
<h2>Post comments</h2>
<form method="post">
  <input name="author" placeholder="Name..." required>
  <textarea name="content" placeholder="Comments..." required></textarea>
  <button>Post</button>
</form>

<?php
if ($_POST) {
    $stmt = $GLOBALS['PDO']->prepare("INSERT INTO comments(author,content,created_at) VALUES(?,?,datetime('now'))");
    $stmt->execute([$_POST['author'], $_POST['content']]);
}
?>
<h3>Comment lists : </h3>
<?php
foreach ($GLOBALS['PDO']->query("SELECT * FROM comments ORDER BY id DESC") as $row) {
    // lakukan output encoding agar aman dari XSS
    $author = htmlspecialchars($row['author'], ENT_QUOTES, 'UTF-8');
    $content = htmlspecialchars($row['content'], ENT_QUOTES, 'UTF-8');
    echo "<p><b>{$author}</b>: {$content}</p>";
}
?>
<?php include '_footer.php'; ?>


