<?php 
require_once "models/invito.php";

session_start();

$data = json_decode(file_get_contents('php://input'), true);

if (!isset($_SESSION['utente_id'])) {
    http_response_code(401);
    return;
}

$utente_id = $_SESSION['utente_id'];

if (
    !isset($data['fantalega_id'])
) {
    http_response_code(400);
    return;
}

$fantalega_id = $data['fantalega_id'];

$invito = Invito::elimina_invito($utente_id, $fantalega_id);

if ($invito) {
    http_response_code(200);
} else {
    http_response_code(500);
}
?>