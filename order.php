<?php
session_start(); header('Content-Type: application/json; charset=utf-8'); require __DIR__.'/db.php';
try{
$d=json_decode(file_get_contents('php://input'),true); if(!$d||empty($d['items'])||empty($d['name'])||empty($d['phone'])) throw new Exception('Completează numele, telefonul și adaugă produse în coș.');
$pdo->beginTransaction(); $total=0;$rows=[];
foreach($d['items'] as $it){$s=$pdo->prepare('SELECT * FROM products WHERE id=? AND active=TRUE FOR UPDATE');$s->execute([(int)$it['id']]);$p=$s->fetch();$q=max(1,(int)($it['qty']??1));if(!$p||$p['stock']<$q)throw new Exception('Un produs nu mai are stoc suficient.');$total+=(float)$p['price']*$q;$rows[]=[$p,$q,$it];}
$s=$pdo->prepare('INSERT INTO orders(customer_id,customer_name,email,phone,address,details,total) VALUES(?,?,?,?,?,?,?) RETURNING id');
$s->execute([$_SESSION['customer']??null,trim($d['name']),trim($d['email']??''),trim($d['phone']),trim($d['address']??''),trim($d['details']??''),$total]);$oid=$s->fetchColumn();
foreach($rows as [$p,$q,$it]){$img=substr((string)($it['personalization_image']??''),0,1600000);$s=$pdo->prepare('INSERT INTO order_items(order_id,product_id,product_name,qty,price,personalization,personalization_image) VALUES(?,?,?,?,?,?,?)');$s->execute([$oid,$p['id'],$p['name'],$q,$p['price'],substr((string)($it['personalization']??''),0,1000),$img]);$pdo->prepare('UPDATE products SET stock=stock-? WHERE id=?')->execute([$q,$p['id']]);}
$pdo->commit();echo json_encode(['ok'=>true,'order_id'=>$oid]);
}catch(Throwable $e){if($pdo->inTransaction())$pdo->rollBack();http_response_code(400);echo json_encode(['ok'=>false,'message'=>$e->getMessage()],JSON_UNESCAPED_UNICODE);}
