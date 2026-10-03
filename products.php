<?php
require __DIR__.'/auth.php'; require_admin(); $msg='';
if($_SERVER['REQUEST_METHOD']==='POST'){
    $act=$_POST['action']??'';
    if($act==='save'){
        $id=(int)($_POST['id']??0); $name=trim($_POST['name']??''); $cat=trim($_POST['category']??'Cadouri');
        $desc=trim($_POST['description']??''); $price=(float)($_POST['price']??0); $old=$_POST['old_price']!==''?(float)$_POST['old_price']:null;
        $stock=max(0,(int)($_POST['stock']??0)); $image=trim($_POST['image']??''); $active=isset($_POST['active']);
        if($name==='') $msg='Numele produsului este obligatoriu.';
        elseif($id){$s=$pdo->prepare('UPDATE products SET name=?,category=?,description=?,price=?,old_price=?,stock=?,image=?,active=? WHERE id=?');$s->execute([$name,$cat,$desc,$price,$old,$stock,$image,$active,$id]);$msg='Produs actualizat.';}
        else{$s=$pdo->prepare('INSERT INTO products(name,category,description,price,old_price,stock,image,active) VALUES(?,?,?,?,?,?,?,?)');$s->execute([$name,$cat,$desc,$price,$old,$stock,$image,$active]);$msg='Produs adăugat.';}
    } elseif($act==='delete'){ $s=$pdo->prepare('DELETE FROM products WHERE id=?');$s->execute([(int)$_POST['id']]);$msg='Produs șters.'; }
}
$edit=null;if(isset($_GET['edit'])){$s=$pdo->prepare('SELECT * FROM products WHERE id=?');$s->execute([(int)$_GET['edit']]);$edit=$s->fetch();}
$rows=$pdo->query('SELECT * FROM products ORDER BY id DESC')->fetchAll();
?><!doctype html><html lang="ro"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Produse — Admin</title>
<style>body{font-family:Arial;background:#f6f6f6;margin:0}.nav{background:#111;padding:16px 4%;display:flex;gap:18px}.nav a{color:#f1bd59}.wrap{max-width:1200px;margin:auto;padding:24px}.panel{background:#fff;padding:20px;border-radius:16px;margin-bottom:20px}input,textarea{width:100%;padding:10px;margin:5px 0;box-sizing:border-box}.row{display:grid;grid-template-columns:1fr 1fr;gap:10px}button{padding:10px 15px;background:#e8ad43;border:0;border-radius:8px}table{width:100%;background:#fff;border-collapse:collapse}td,th{padding:10px;border-bottom:1px solid #eee;text-align:left}.thumb{width:70px;height:55px;object-fit:cover}@media(max-width:700px){.row{grid-template-columns:1fr}}</style></head><body>
<nav class="nav"><a href="index.php">Dashboard</a><a href="products.php">Produse</a><a href="orders.php">Comenzi</a><a href="../">Magazin</a><a href="logout.php">Ieșire</a></nav><main class="wrap"><h1>Produse</h1><p><?=htmlspecialchars($msg)?></p>
<form method="post" class="panel"><input type="hidden" name="action" value="save"><input type="hidden" name="id" value="<?=$edit['id']??''?>">
<div class="row"><input name="name" placeholder="Nume produs" required value="<?=htmlspecialchars($edit['name']??'')?>"><input name="category" placeholder="Categorie" value="<?=htmlspecialchars($edit['category']??'Cadouri')?>"></div>
<textarea name="description" placeholder="Descriere"><?=htmlspecialchars($edit['description']??'')?></textarea>
<div class="row"><input type="number" step="0.01" name="price" placeholder="Preț" value="<?=htmlspecialchars($edit['price']??'')?>"><input type="number" step="0.01" name="old_price" placeholder="Preț vechi" value="<?=htmlspecialchars($edit['old_price']??'')?>"></div>
<div class="row"><input type="number" name="stock" placeholder="Stoc" value="<?=htmlspecialchars($edit['stock']??0)?>"><input name="image" placeholder="URL fotografie" value="<?=htmlspecialchars($edit['image']??'')?>"></div>
<label><input style="width:auto" type="checkbox" name="active" <?=(!isset($edit['active'])||$edit['active'])?'checked':''?>> Produs activ</label><br><button>Salvează produsul</button></form>
<table><tr><th>Foto</th><th>Produs</th><th>Preț</th><th>Stoc</th><th>Acțiuni</th></tr><?php foreach($rows as $r):?><tr>
<td><?php if($r['image']):?><img class="thumb" src="<?=htmlspecialchars($r['image'])?>"><?php endif;?></td><td><?=htmlspecialchars($r['name'])?><br><small><?=htmlspecialchars($r['category'])?></small></td>
<td><?=number_format($r['price'],2,',',' ')?> lei</td><td><?=$r['stock']?></td><td><a href="?edit=<?=$r['id']?>">Editează</a> <form method="post" style="display:inline" onsubmit="return confirm('Ștergi produsul?')"><input type="hidden" name="action" value="delete"><input type="hidden" name="id" value="<?=$r['id']?>"><button>Șterge</button></form></td></tr><?php endforeach;?></table></main></body></html>