<?php
/**
 * Vérifie si l'utilisateur est connecté
 */
session_start();

if (!isset($_SESSION['admin_auth']) || $_SESSION['admin_auth'] !== true) {
    header('Location: login.php');
    exit;
}
