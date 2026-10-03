<?php
header('Content-Type: application/json; charset=utf-8'); require __DIR__.'/db.php';
echo json_encode($pdo->query("SELECT * FROM products WHERE active=TRUE ORDER BY id DESC")->fetchAll(), JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);
