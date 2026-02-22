<?php
require 'core/database.php';
$config = require 'config.php';

$db = new Database($config['database']);
$pdo = $db->getPdo(); // Вот так просто!

// Проверяем, что форма отправлена
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $blog_id = trim($_POST['blog_id'] ?? '');
    $comment_body = trim($_POST['comment_body'] ?? '');

    if (empty($blog_id) || empty($comment_body)) {
        die("Ошибка: blog_id и комментарий обязательны");
    }

    $sql = "INSERT INTO comments (blog_id, comment_body) VALUES (:blog_id, :comment_body)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':blog_id' => $blog_id,
        ':comment_body' => $comment_body
    ]);

    header('Location: index.php');
    exit;
}

header('Location: index.php');
exit;