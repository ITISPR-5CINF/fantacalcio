<?php
require_once "models/fantalega.php";

session_start();

if (!isset($_SESSION['utente_id'])) {
	http_response_code(401);
	return;
}

$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['nome'])) {
	http_response_code(400);
	return;
}

$admin_id = $_SESSION['utente_id'];
$nome = $data['nome'];

$fantalega = Fantalega::crea_fantalega($nome, $admin_id);
if (!$fantalega) {
	http_response_code(401);
	return;
}

print($fantalega->to_json());
?>
