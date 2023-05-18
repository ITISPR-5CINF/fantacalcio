<?php
require_once "models/utente.php";
require_once "models/fantasquadra.php";

session_start();

if (!isset($_SESSION['utente_id'])) {
    http_response_code(401);
    return;
}

$utente = Utente::from_id($_SESSION['utente_id']);
if (!$utente) {
    http_response_code(401);
    return;
}

$fantasquadre = $utente->get_fantaleghe_utente();

print(json_encode($fantasquadre));
?>