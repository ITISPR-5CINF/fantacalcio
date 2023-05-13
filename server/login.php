<?php
require_once "database/database.php";
require_once "models/utente.php";

session_start();

if (!isset($_POST['username']) || !isset($_POST['password'])) {
    http_response_code(400);
    return;
}

$username = $_POST['username'];
$password = $_POST['password'];

$utente = Utente::login($username, $password);
if (!$utente) {
    http_response_code(401);
    return;
}

$_SESSION['utente_id'] = $utente->utente_id;
?>