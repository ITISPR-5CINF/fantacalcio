<?php 
require_once "models/giocatore.php";
require_once "models/squadra.php";

if (isset($_GET['squadra_id'])) {
	$squadra_id = $_GET['squadra_id'];
	$squadra = Squadra::from_id($squadra_id);

	if ($squadra == null) {
		http_response_code(400);
		return;
	}

	$giocatori = $squadra->get_giocatori();
} else {
	$giocatori = Giocatore::get_all();
}

if ($giocatori == null) {
	http_response_code(500);
	return;
}

print(json_encode($giocatori));
?>
