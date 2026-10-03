<?php
$url = getenv('DATABASE_URL');
if (!$url) { http_response_code(500); exit('DATABASE_URL nu este configurat în Render.'); }
$p = parse_url($url);
if (!$p || empty($p['host']) || empty($p['path'])) { http_response_code(500); exit('DATABASE_URL este invalid.'); }
$host=$p['host']; $port=$p['port']??5432; $db=ltrim($p['path'],'/'); $user=$p['user']??''; $pass=$p['pass']??'';
$pdo = new PDO("pgsql:host={$host};port={$port};dbname={$db};sslmode=require", $user, $pass, [PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC]);
