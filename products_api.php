<?php
header('Content-Type: application/json; charset=utf-8');
require __DIR__.'/db.php';
$products=$pdo->query("SELECT * FROM products WHERE active=TRUE ORDER BY id DESC")->fetchAll();
$images=[
  'assets/images/magneti-botez-01.webp',
  'assets/images/magneti-botez-02.webp',
  'assets/images/magneti-botez-03.webp',
  'assets/images/magneti-botez-04.webp',
  'assets/images/magneti-botez-05.webp',
];
foreach($products as $index=>&$product){$product['image']=$images[$index%count($images)];}
unset($product);
echo json_encode($products, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);
