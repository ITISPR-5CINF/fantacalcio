<?php

require_once "base.php";
require_once __DIR__."/../database/database.php";

/**
 * Classe che rappresenta un utente del sito.
 */
class Utente implements Base {
	public $utente_id;
	public $username;
	public $nome;
	public $cognome;
	public $email;

	function __construct($utente_id, $username, $nome, $cognome, $email) {
		$this->utente_id = $utente_id;
		$this->username = $username;
		$this->nome = $nome;
		$this->cognome = $cognome;
		$this->email = $email;
	}

	function to_assoc_array() {
		return array(
			"utente_id" => $this->utente_id,
			"username" => $this->username,
			"nome" => $this->nome,
			"cognome" => $this->cognome,
			"email" => $this->email,
		);
	}

	function to_json() {
		return json_encode(to_assoc_array());
	}

	/**
	 * Restituisce un utente dato il suo id.
	 * @param $utente_id id del giocatore da cercare
	 * @return null|Utente utente trovato, null se non trovato
	 */
	static function from_id($utente_id) {
		$utente_id = intval($utente_id);

		$conn = Database::get_connection();
		if ($conn->connect_error) {
			return null;
		}

		$sql = "SELECT * FROM utenti WHERE utenti.utente_id = $utente_id";
		$query = $conn->query($sql);
		if (!$query) {
			return null;
		}

		$row = $query->fetch_assoc();
		$utente = new Utente(
			$row['utente_id'],
			$row['username'],
			$row['nome'],
			$row['cognome'],
			$row['email'],
		);

		$conn->close();

		return $utente;
	}	
}
?>
