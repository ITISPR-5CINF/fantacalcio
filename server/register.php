<?php
require_once "models/utente.php";

session_start();

if (
    !isset($_POST['username']) ||
    !isset($_POST['nome']) ||
    !isset($_POST['cognome']) ||
    !isset($_POST['email']) ||
    !isset($_POST['password'])
) {
    http_response_code(400);
    return;
}

$username = $_POST['username'];
$nome = $_POST['nome'];
$cognome = $_POST['cognome'];
$email = $_POST['email'];
$password = $_POST['password'];

$utente = Utente::register($username, $nome, $cognome, $email, $password);
if (!$utente) {
    http_response_code(401);
    return;
}

$_SESSION['utente_id'] = $utente->utente_id;
?>