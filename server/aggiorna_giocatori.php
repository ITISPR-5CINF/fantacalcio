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

for ($i = 0; $i < count($json); $i++) {
	$cognome_nome = $json[$i]["cognome_nome"];
	$data_nascita = $json[$i]["data_nascita"];
	$posizione = $json[$i]["posizione"];
	$crediti_iniziali = $json[$i]["crediti_iniziali"];
	$crediti_finali = $json[$i]["crediti_finali"];
	$squadra = $json[$i]["squadra"];
	$nazionalita = $json[$i]["nazionalita"];

	//Squadra è una stringa, quindi devo convertirla in id
	$squadra_id = $squadre[$squadra];

	$sql = "INSERT INTO giocatori (cognome_nome, data_nascita, posizione, crediti_iniziali, crediti_finali, squadra_id) VALUES ('$cognome_nome', '$data_nascita', '$posizione', '$crediti_iniziali', '$crediti_finali', '$squadra_id')";
	$result = $connect->query($sql);

	// Aggiungere le nazionalità (array di string) nella tabella nazionalita_giocatori
	$giocatore_id = $connect->insert_id;
	for ($j = 0; $j < count($nazionalita); $j++) {
		$nazionalita_id = $nazionalita[$j];
		$sql = "INSERT INTO nazionalita_giocatori (giocatore_id, nazionalita_id) VALUES ('$giocatore_id', '$nazionalita_id')";
		$result = $connect->query($sql);
	}

	print("Aggiunto giocatore: $cognome_nome");
}
?>
