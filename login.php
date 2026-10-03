<?php
session_start();
require __DIR__.'/../db.php';
if (!empty($_SESSION['admin_id'])) { header('Location: index.php'); exit; }
$msg='';
if ($_SERVER['REQUEST_METHOD']==='POST') {
    $u=trim($_POST['username']??'');
    $p=$_POST['password']??'';
    $s=$pdo->prepare('SELECT * FROM admins WHERE username=?');
    $s->execute([$u]);
    $a=$s->fetch();
    if($a && password_verify($p,$a['password_hash'])){
        session_regenerate_id(true);
        $_SESSION['admin_id']=$a['id'];
        $_SESSION['admin_username']=$a['username'];
        header('Location: index.php'); exit;
    }
    $msg='Utilizator sau parolă incorectă.';
}
?><!doctype html><html lang="ro"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title>Admin — CreativArt</title><style>
body{font-family:Arial;background:#f5f5f5;margin:0}.box{max-width:430px;margin:10vh auto;background:white;padding:30px;border-radius:18px;box-shadow:0 10px 35px #0002}
input,button{width:100%;padding:13px;margin:7px 0;box-sizing:border-box;border-radius:9px;border:1px solid #ccc}button{background:#e8ad43;border:0;font-weight:700}
</style></head><body><div class="box"><h1>CreativArt Admin</h1><?php if($msg):?><p><?=htmlspecialchars($msg)?></p><?php endif;?>
<form method="post"><input name="username" placeholder="Utilizator" required><input type="password" name="password" placeholder="Parolă" required><button>Autentificare</button></form>
<p><a href="../">← Înapoi la magazin</a></p></div></body></html>