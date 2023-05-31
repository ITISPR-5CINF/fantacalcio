<?php
require_once "models/fantasquadra.php";
require_once "models/invito.php";
require_once "models/utente.php";

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

$data = json_decode(file_get_contents('php://input'), true);

if (
	!isset($data['fantalega_id']) ||
	!isset($data['nome_fantasquadra'])
) {
	http_response_code(400);
	return;
}

$fantalega_id = $data['fantalega_id'];
$nome_fantasquadra = $data['nome_fantasquadra'];

// Controlla se l'utente ha un invito attivo per la lega
$invito = Invito::get_invito($utente->utente_id, $fantalega_id);
if (!$invito) {
	http_response_code(403);
	return;
}

$invito->elimina_invito();

$fantasquadra = Fantasquadra::crea_fantasquadra($nome_fantasquadra, $fantalega_id, $utente->utente_id);
if (!$fantasquadra) {
	http_response_code(500);
	return;
}

print($fantasquadra->to_json());
?>