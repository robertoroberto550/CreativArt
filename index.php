<?php
require __DIR__.'/auth.php'; require_admin();
$products=(int)$pdo->query('SELECT COUNT(*) FROM products')->fetchColumn();
$customers=(int)$pdo->query('SELECT COUNT(*) FROM customers')->fetchColumn();
$orders=(int)$pdo->query('SELECT COUNT(*) FROM orders')->fetchColumn();
$revenue=(float)$pdo->query("SELECT COALESCE(SUM(total),0) FROM orders WHERE status <> 'Anulată'")->fetchColumn();
$low=(int)$pdo->query('SELECT COUNT(*) FROM products WHERE stock <= 5 AND active=TRUE')->fetchColumn();
$latest=$pdo->query('SELECT id,customer_name,total,status,created_at FROM orders ORDER BY id DESC LIMIT 8')->fetchAll();
?><!doctype html><html lang="ro"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Dashboard — CreativArt</title>
<style>body{font-family:Arial;background:#f6f6f6;margin:0}.nav{background:#111;color:#fff;padding:16px 4%;display:flex;gap:20px;flex-wrap:wrap}.nav a{color:#f1bd59;text-decoration:none}.wrap{max-width:1200px;margin:auto;padding:25px}.stats{display:grid;grid-template-columns:repeat(auto-fit,minmax(180px,1fr));gap:15px}.card{background:#fff;padding:20px;border-radius:16px;box-shadow:0 5px 20px #0001}.n{font-size:30px;font-weight:bold}.warn{color:#c62828}table{width:100%;border-collapse:collapse;background:#fff;margin-top:20px}th,td{padding:12px;border-bottom:1px solid #eee;text-align:left}</style></head><body>
<nav class="nav"><b>CreativArt Admin</b><a href="index.php">Dashboard</a><a href="products.php">Produse</a><a href="orders.php">Comenzi</a><a href="../">Magazin</a><a href="logout.php">Ieșire</a></nav>
<main class="wrap"><h1>Dashboard</h1><div class="stats">
<div class="card"><div>Produse</div><div class="n"><?=$products?></div></div><div class="card"><div>Clienți</div><div class="n"><?=$customers?></div></div>
<div class="card"><div>Comenzi</div><div class="n"><?=$orders?></div></div><div class="card"><div>Valoare comenzi</div><div class="n"><?=number_format($revenue,2,',',' ')?> lei</div></div>
<div class="card"><div>Stoc ≤ 5</div><div class="n warn"><?=$low?></div></div></div>
<h2>Ultimele comenzi</h2><table><tr><th>#</th><th>Client</th><th>Total</th><th>Status</th><th>Data</th></tr>
<?php foreach($latest as $o):?><tr><td><?=$o['id']?></td><td><?=htmlspecialchars($o['customer_name'])?></td><td><?=number_format($o['total'],2,',',' ')?> lei</td><td><?=htmlspecialchars($o['status'])?></td><td><?=$o['created_at']?></td></tr><?php endforeach;?></table></main></body></html>