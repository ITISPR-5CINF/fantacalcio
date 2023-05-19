<?php
require_once "models/giocatore.php";

if (!isset($_GET['giocatore_id'])) {
	die("No id provided");
}

$giocatore_id = $_GET['giocatore_id'];
$giocatore = Giocatore::from_id($giocatore_id);

if ($giocatore == null) {
	http_response_code(404);
	return;
}

echo $giocatore->to_json();
?>
