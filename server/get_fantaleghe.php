<?php
require_once "models/fantalega.php";

session_start();

if (!isset($_SESSION['utente_id'])) {
    http_response_code(401);
    return;
}

$utente_id = $_SESSION['utente_id'];

$fantasquadre = 

?>
