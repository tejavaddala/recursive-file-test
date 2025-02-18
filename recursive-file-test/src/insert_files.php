<?php
include 'db.php';

function insertFile($name, $parent_id, $type, $path) {
    global $pdo;
    $stmt = $pdo->prepare("INSERT INTO file_system (name, parent_id, type, path) VALUES (?, ?, ?, ?)");
    $stmt->execute([$name, $parent_id, $type, $path]);
    return $pdo->lastInsertId();
}

function parseAndInsert($file, $parent_id = NULL, $path = "C:\\") {
    foreach ($file as $line) {
        $line = trim($line);
        if (!empty($line)) {
            $type = (strpos($line, '.') === false) ? 'folder' : 'file';
            $new_path = $path . "\\" . $line;
            $id = insertFile($line, $parent_id, $type, $new_path);
            
            if ($type == 'folder') {
                parseAndInsert(glob($new_path . '\\*'), $id, $new_path);
            }
        }
    }
}

$file_structure = file('file_structure.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
parseAndInsert($file_structure);
?>