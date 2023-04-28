<!DOCTYPE html>
<html>

<head>
	<title>Aggiorna giocatori</title>
	<meta charset="utf-8">
</head>

<body>
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

	// Prepara lo statement per l'inserimento dei giocatori
	$sql = "INSERT INTO giocatori (cognome_nome, data_nascita, posizione, crediti_iniziali, crediti_finali, squadra_id) " .
		"VALUES (?, STR_TO_DATE(?, '%Y-%m-%d'), ?, ?, ?, ?)";
	$statement = $connect->prepare($sql);
	if (!$statement) {
		echo "Errore durante la preparazione dello statement: $mysqli->error";
		exit(1);
	}
	$statement->bind_param("ssssii", $cognome_nome, $data_nascita, $posizione, $crediti_iniziali, $crediti_finali, $squadra_id);

	print("<table>");
	print("    <tr>");
	print("        <th>Cognome e nome</th>");
	print("        <th>Data di nascita</th>");
	print("        <th>Posizione</th>");
	print("        <th>Crediti iniziali</th>");
	print("        <th>Crediti finali</th>");
	print("        <th>Squadra</th>");
	print("        <th>Nazionalità</th>");
	print("    </tr>");

	// Aggiungi i giocatori
	foreach ($json as $giocatore) {
		$cognome_nome = $giocatore["cognome_nome"];
		$data_nascita = $giocatore["data_nascita"];
		$posizione = $giocatore["posizione"];
		$crediti_iniziali = $giocatore["crediti_iniziali"];
		$crediti_finali = $giocatore["crediti_finali"];
		$squadra = $giocatore["squadra"];
		$nazionalita = $giocatore["nazionalita"];

		// Squadra è una stringa, quindi deve essere convertita in id
		if (!array_key_exists($squadra, $squadre)) {
			echo "Errore: squadra $squadra non trovata";
			exit(1);
		}

		$squadra_id = $squadre[$squadra];

		// Aggiungere il giocatore nella tabella giocatori
		$statement->execute();
		$error = $statement->error;
		if ($error) {
			echo "Errore durante l'aggiunta di $cognome_nome: $error";
			exit(1);
		}

		// Aggiungere le nazionalità (array di string) nella tabella nazionalita_giocatori
		$giocatore_id = $statement->insert_id;
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

		print("    <tr>");
		print("        <td>$cognome_nome</td>");
		print("        <td>$data_nascita</td>");
		print("        <td>$posizione</td>");
		print("        <td>$crediti_iniziali</td>");
		print("        <td>$crediti_finali</td>");
		print("        <td>$squadra</td>");
		print("        <td>");
		foreach ($nazionalita as $nazione) {
			print("$nazione, ");
		}
		print("</td>");
		print("    </tr>");
	}

	print("</table>");
	?>
</body>

</html>
