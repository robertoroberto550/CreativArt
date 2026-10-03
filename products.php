<?php
header('Content-Type: application/json; charset=utf-8'); require dirname(__DIR__).'/db.php';
echo json_encode($pdo->query('SELECT * FROM products WHERE active=1 ORDER BY id DESC')->fetchAll(), JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);
