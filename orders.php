<?php
require __DIR__.'/auth.php'; require_admin(); $msg='';
$statuses=['Nouă','Confirmată','În lucru','Expediată','Livrată','Finalizată','Anulată'];
if($_SERVER['REQUEST_METHOD']==='POST'){
 $id=(int)($_POST['id']??0);$status=$_POST['status']??'';
 if(in_array($status,$statuses,true)){$s=$pdo->prepare('UPDATE orders SET status=? WHERE id=?');$s->execute([$status,$id]);$msg='Status actualizat.';}
}
$orders=$pdo->query('SELECT * FROM orders ORDER BY id DESC')->fetchAll();
?><!doctype html><html lang="ro"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Comenzi — Admin</title>
<style>body{font-family:Arial;background:#f6f6f6;margin:0}.nav{background:#111;padding:16px 4%;display:flex;gap:18px}.nav a{color:#f1bd59}.wrap{max-width:1200px;margin:auto;padding:24px}.order{background:#fff;padding:18px;border-radius:16px;margin:14px 0}.items{background:#fafafa;padding:10px;margin-top:10px}select,button{padding:9px}</style></head><body>
<nav class="nav"><a href="index.php">Dashboard</a><a href="products.php">Produse</a><a href="orders.php">Comenzi</a><a href="../">Magazin</a><a href="logout.php">Ieșire</a></nav><main class="wrap"><h1>Comenzi</h1><p><?=htmlspecialchars($msg)?></p>
<?php foreach($orders as $o):$s=$pdo->prepare('SELECT * FROM order_items WHERE order_id=? ORDER BY id');$s->execute([$o['id']]);$items=$s->fetchAll();?>
<section class="order"><h2>Comanda #<?=$o['id']?> — <?=number_format($o['total'],2,',',' ')?> lei</h2>
<p><b><?=htmlspecialchars($o['customer_name'])?></b> · <?=htmlspecialchars($o['phone'])?> · <?=htmlspecialchars($o['email']??'')?></p><p><?=nl2br(htmlspecialchars($o['address']??''))?></p>
<?php if($o['details']):?><p><b>Detalii:</b> <?=nl2br(htmlspecialchars($o['details']))?></p><?php endif;?>
<form method="post"><input type="hidden" name="id" value="<?=$o['id']?>"><select name="status"><?php foreach($statuses as $st):?><option <?=$st===$o['status']?'selected':''?>><?=htmlspecialchars($st)?></option><?php endforeach;?></select><button>Actualizează</button></form>
<div class="items"><?php foreach($items as $it):?><p><b><?=htmlspecialchars($it['product_name'])?></b> × <?=$it['qty']?> — <?=number_format($it['price'],2,',',' ')?> lei<?php if($it['personalization']):?><br>Text: <?=htmlspecialchars($it['personalization'])?><?php endif;?><?php if($it['personalization_image']):?><br><img src="<?=htmlspecialchars($it['personalization_image'])?>" style="max-width:180px;max-height:180px"><?php endif;?></p><?php endforeach;?></div></section><?php endforeach;?></main></body></html>