<?php
require_once "models/fantalega.php";
require_once "models/fantasquadra.php";

session_start();

if (!isset($_SESSION['utente_id'])) {
	http_response_code(401);
	return;
}

$data = json_decode(file_get_contents('php://input'), true);

if (
	!isset($data['nome_fantalega']) ||
	!isset($data['nome_fantasquadra'])
) {
	http_response_code(400);
	return;
}

$admin_id = $_SESSION['utente_id'];
$nome_fantalega = $data['nome_fantalega'];
$nome_fantasquadra = $data['nome_fantasquadra'];

$fantalega = Fantalega::crea_fantalega($nome_fantalega, $admin_id);
if (!$fantalega) {
	http_response_code(401);
	return;
}

$fantasquadra = Fantasquadra::crea_fantasquadra($nome_fantasquadra, $fantalega->fantalega_id, $admin_id);
if (!$fantasquadra) {
	http_response_code(500);
	return;
}

print($fantalega->to_json());
?>
