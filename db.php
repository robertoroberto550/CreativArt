<?php
$url = getenv('DATABASE_URL');
if (!$url) { http_response_code(500); exit('DATABASE_URL nu este configurat în Render.'); }
$p = parse_url($url);
if (!$p || empty($p['host']) || empty($p['path'])) { http_response_code(500); exit('DATABASE_URL este invalid.'); }
$host=$p['host']; $port=$p['port']??5432; $db=ltrim($p['path'],'/'); $user=$p['user']??''; $pass=$p['pass']??'';
$pdo = new PDO("pgsql:host={$host};port={$port};dbname={$db};sslmode=require", $user, $pass, [PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC]);

// Inițializare automată, idempotentă, a schemei PostgreSQL.
// database.sql folosește CREATE TABLE IF NOT EXISTS și INSERT ... WHERE NOT EXISTS,
// deci poate fi rulat în siguranță la pornirea unei cereri.
$schemaFile = __DIR__ . '/database.sql';
if (is_file($schemaFile)) {
    try {
        $pdo->exec(file_get_contents($schemaFile));
    } catch (Throwable $e) {
        error_log('CreativArt DB init failed: ' . $e->getMessage());
        http_response_code(500);
        exit('Baza de date CreativArt nu a putut fi inițializată. Verifică logurile Render.');
    }
}
