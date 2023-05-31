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
	if (isset($_GET['posizione'])) {
		$posizione = $_GET['posizione'];
	} else {
		$posizione = null;
	}

	if (isset($_GET['nazionalita'])) {
		$nazionalita = $_GET['nazionalita'];
	} else {
		$nazionalita = null;
	}

	if (isset($_GET['cognome_nome'])) {
		$cognome_nome = $_GET['cognome_nome'];
	} else {
		$cognome_nome = null;
	}

	if (isset($_GET['limit'])) {
		$limit = $_GET['limit'];
	} else {
		$limit = null;
	}

	$giocatori = Giocatore::cerca_giocatori($posizione, $nazionalita, $cognome_nome, $limit);
}

if (is_null($giocatori)) {
	http_response_code(500);
	return;
}

print(json_encode($giocatori));
?>
