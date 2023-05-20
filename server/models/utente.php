<?php
require_once "base.php";
require_once __DIR__."/../database/database.php";
require_once "fantalega.php";

/**
 * Classe che rappresenta un utente del sito.
 */
class Utente extends Base {
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

	/**
	 * Restituisce un utente dato il suo id.
	 * @param $utente_id id del giocatore da cercare
	 * @return null|Utente utente trovato, null se non trovato
	 */
	static function from_id($utente_id) {
		$utente_id = intval($utente_id);

		$conn = Database::get_connection();
		if (!$conn) {
			return null;
		}

		$sql = "SELECT * FROM utenti WHERE utenti.utente_id = $utente_id";
		$query = $conn->query($sql);
		if (!$query) {
			return null;
		}

		if ($query->num_rows == 0) {
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

	static function from_username($username) {
		$conn = Database::get_connection();
		if (!$conn) {
			return null;
		}

		$sql = "SELECT * FROM utenti WHERE utenti.username = '$username'";
		$query = $conn->query($sql);
		if (!$query) {
			return null;
		}

		if ($query->num_rows == 0) {
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

	static function login($username, $password) {
		$conn = Database::get_connection();
		if (!$conn) {
			return null;
		}

		$sql = "SELECT * FROM utenti WHERE utenti.username = '$username' AND utenti.password = '$password'";
		$query = $conn->query($sql);
		if (!$query) {
			return null;
		}

		if ($query->num_rows == 0) {
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

	static function register(
		$username,
		$password,
		$nome,
		$cognome,
		$email
	) {
		$conn = Database::get_connection();
		if (!$conn) {
			return null;
		}

		// Lock table
		$sql = "LOCK TABLES utenti WRITE";
		$query = $conn->query($sql);
		if (!$query) {
			return null;
		}

		// Controlla se l'utente esiste già
		$sql = "SELECT *".
		       " FROM utenti".
			   " WHERE utenti.username = '$username' OR utenti.email = '$email'";
		$query = $conn->query($sql);
		if (!$query) {
			return null;
		}

		if ($query->num_rows > 0) {
			// Utente già esistente
			$conn->close();
			return null;
		}

		$sql = "INSERT INTO utenti (username, password, nome, cognome, email) VALUES ('$username', '$password', '$nome', '$cognome', '$email')";
		$query = $conn->query($sql);
		if (!$query) {
			return null;
		}

		$conn->close();

		return Utente::from_username($username);
	}

	/**
	 * Ottieni la lista delle fantaleghe di cui l'utente fa parte.
	 */
	function get_fantaleghe_utente() {
		$conn = Database::get_connection();
		if (!$conn) {
			return null;
		}

		$sql = "SELECT fantaleghe.fantalega_id".
		       " FROM fantaleghe LEFT JOIN fantasquadre ON fantasquadre.fantalega_id = fantaleghe.fantalega_id".
			   " WHERE fantasquadre.utente_id = $this->utente_id OR fantaleghe.admin_id = $this->utente_id";
		$query = $conn->query($sql);
		if (!$query) {
			return null;
		}

		$fantaleghe = array();
		while ($row = $query->fetch_assoc()) {
			$fantaleghe[] = Fantalega::from_id($row['fantalega_id']);
		}

		$conn->close();

		return $fantaleghe;
	}

	function get_inviti_attivi() {
		return Invito::get_inviti_utente($this->utente_id);
	}
}
?>
