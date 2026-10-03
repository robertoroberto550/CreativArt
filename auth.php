<?php
session_start();
require __DIR__.'/../db.php';
function require_admin(): void {
    if (empty($_SESSION['admin_id'])) {
        header('Location: login.php');
        exit;
    }
}
