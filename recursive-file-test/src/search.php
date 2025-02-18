<?php
include 'db.php';
if (isset($_GET['query'])) {
    $query = '%' . $_GET['query'] . '%';
    $stmt = $pdo->prepare("SELECT path FROM file_system WHERE path LIKE ?");
    $stmt->execute([$query]);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>
<html>
<body>
<form method="GET">
    <input type="text" name="query" placeholder="Search files...">
    <button type="submit">Search</button>
</form>
<?php if (!empty($results)) : ?>
    <ul>
        <?php foreach ($results as $result) : ?>
            <li><?= htmlspecialchars($result['path']) ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>
</body>
</html>