<?php
require "database/Database.php";

$connect = Database::get_connection();
if ($connect->connect_error) {
	exit("Errore connessione: " . $connect->connect_error);
}

$uploadOk = 1;

// Check file size
if ($_FILES["fileToUpload"]["size"] > 500000) {
	echo "Sorry, your file is too large.";
	$uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
	echo "Sorry, your file was not uploaded.";
	exit(1);
}

$json = json_decode(file_get_contents($_FILES["fileToUpload"]["tmp_name"]), true);
if (!$json) {
	echo "Sorry, there was an error uploading your file.";
	exit(1);
}

$squadre = array();
$sql = "SELECT * FROM squadre";
$result = $connect->query($sql);
while ($row = $result->fetch_assoc()) {
	$squadre[$row["nome"]] = $row["squadra_id"];
}

// Elimina tutti i giocatori
$sql = "DELETE FROM giocatori";
$result = $connect->query($sql);
$error = $connect->error;
if ($error) {
	echo "Errore durante l'eliminazione dei giocatori: $error";
	exit(1);
}

foreach ($json as $giocatore) {
	$cognome_nome = $giocatore["cognome_nome"];
	$data_nascita = $giocatore["data_nascita"];
	$posizione = $giocatore["posizione"];
	$crediti_iniziali = $giocatore["crediti_iniziali"];
	$crediti_finali = $giocatore["crediti_finali"];
	$squadra = $giocatore["squadra"];
	$nazionalita = $giocatore["nazionalita"];

	//Squadra è una stringa, quindi devo convertirla in id
	$squadra_id = $squadre[$squadra];

	$sql = "INSERT INTO giocatori (cognome_nome, data_nascita, posizione, crediti_iniziali, crediti_finali, squadra_id) VALUES ('$cognome_nome', STR_TO_DATE('$data_nascita', '%Y-%m-%d'), '$posizione', '$crediti_iniziali', '$crediti_finali', '$squadra_id')";
	$result = $connect->query($sql);
	$error = $connect->error;
	if ($error) {
		echo "Errore durante l'aggiunta di $cognome_nome: $error";
		exit(1);
	}

	// Aggiungere le nazionalità (array di string) nella tabella nazionalita_giocatori
	$giocatore_id = $connect->insert_id;
	for ($j = 0; $j < count($nazionalita); $j++) {
		$nazione = $nazionalita[$j];
		$sql = "INSERT INTO nazionalita_giocatori (giocatore_id, nazione) VALUES ('$giocatore_id', '$nazione')";
		$result = $connect->query($sql);
		$error = $connect->error;
		if ($error) {
			echo "Errore durante l'aggiunta della nazionalità di $cognome_nome $nazione: $error";
			exit(1);
		}
	}

	print("Aggiunto giocatore: $cognome_nome\n");
}
?>
