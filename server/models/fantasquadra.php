<?php
require_once "base.php";
require_once __DIR__."/../database/database.php";
require_once "fantalega.php";
require_once "utente.php";

class Fantasquadra extends Base {
	public $fantasquadra_id;
	public $nome;
	public $fantalega_id;
	public $utente_id;

	function __construct(
		$fantasquadra_id,
		$nome,
		$fantalega_id,
		$utente_id
	) {
		$this->fantasquadra_id = $fantasquadra_id;
		$this->nome = $nome;
		$this->fantalega_id = $fantalega_id;
		$this->utente_id = $utente_id;
	}

	/**
	 * Ottieni informazioni sull'utente della fantasquadra.
	 * @return null|Utente utente della fantasquadra, null se non trovato
	 */
	function get_utente() {
		return Utente::from_id($this->utente_id);
	}

	/**
	 * Ottieni informazioni sulla fantalega della fantasquadra.
	 * @return null|Fantalega fantalega della fantasquadra, null se non trovato
	 */
	function get_fantalega() {
		return Fantalega::from_id($this->fantalega_id);
	}

	/**
	 * Ottieni la lista di giocatori della fantasquadra.
	 * @return null|Giocatore[] lista di giocatori della fantasquadra, null se non trovata
	 */
	function get_giocatori() {
		$conn = Database::get_connection();
		if (!$conn) {
			return null;
		}

		$sql = "SELECT giocatori.giocatore_id AS giocatore_id".
		       " FROM giocatori".
			   " WHERE giocatori.fantasquadra_id = $this->fantasquadra_id";
		$query = $conn->query($sql);
		if (!$query) {
			return null;
		}

		$giocatori = array();
		while ($row = $query->fetch_assoc()) {
			$giocatori[] = Giocatore::from_id($row["giocatore_id"]);
		}

		$conn->close();

		return $giocatori;
	}
}
?>
