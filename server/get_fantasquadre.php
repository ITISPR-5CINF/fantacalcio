<?php
require_once "models/fantalega.php";

session_start();

if (!isset($_SESSION['utente_id'])) {
    http_response_code(401);
    return;
}

$utente_id = $_SESSION['utente_id'];

if (!isset($_GET['fantalega_id'])) {
	http_response_code(400);
	return;
}

$fantalega_id = $_GET['fantalega_id'];

$fantalega = Fantalega::from_id($fantalega_id);
if ($fantalega == null) {
	http_response_code(404);
	return;
}

print(json_encode($fantalega->get_fantasquadre()));
?>
