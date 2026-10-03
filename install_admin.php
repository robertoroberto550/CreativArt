<?php
session_start(); require __DIR__.'/db.php';
$count=(int)$pdo->query('SELECT COUNT(*) FROM admins')->fetchColumn();
$msg='';
if($_SERVER['REQUEST_METHOD']==='POST' && $count===0){$u=trim($_POST['username']??'');$p=$_POST['password']??''; if(strlen($u)>=4 && strlen($p)>=8){$s=$pdo->prepare('INSERT INTO admins(username,password_hash) VALUES(?,?)');$s->execute([$u,password_hash($p,PASSWORD_DEFAULT)]);$msg='Cont creat. Șterge install_admin.php de pe server și intră în /admin/.';$count=1;}else{$msg='Folosește minimum 4 caractere la utilizator și 8 la parolă.';}}
?><!doctype html><html lang="ro"><meta charset="utf-8"><title>Instalare Admin CreativArt</title><style>body{font-family:Arial;max-width:520px;margin:60px auto;padding:20px}input,button{width:100%;padding:12px;margin:7px 0;box-sizing:border-box}</style><h1>CreativArt — creare Admin</h1><p><?=htmlspecialchars($msg)?></p><?php if(!$count):?><form method="post"><input name="username" placeholder="Utilizator admin" required><input type="password" name="password" placeholder="Parolă (min. 8 caractere)" required><button>Creează contul Admin</button></form><?php else:?><p>Există deja un administrator.</p><?php endif;?></html>
