<?php
include 'db.php';

class SearchController {
    public static function search() {
        if (isset($_GET['query'])) {
            global $pdo;
            $query = '%' . $_GET['query'] . '%';
            $stmt = $pdo->prepare("SELECT path FROM file_system WHERE path LIKE ?");
            $stmt->execute([$query]);
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            include '../views/search.php';
        } else {
            include '../views/search.php';
        }
    }
}
?>
