<?php
require_once "base.php";
require_once __DIR__."/../database/database.php";
require_once "invito.php";
require_once "utente.php";
require_once "fantasquadra.php";

/**
 * Classe che rappresenta una fantalega.
 */
class Fantalega extends Base {
	public $fantalega_id;
	public $nome;
	public $admin_id;

	function __construct(
		$fantalega_id,
		$nome,
		$admin_id
	) {
		$this->fantalega_id = $fantalega_id;
		$this->nome = $nome;
		$this->admin_id = $admin_id;
	}

	/**
	 * Ottieni informazioni sull'utente admin della fantalega.
	 * @return null|Utente utente admin della fantalega, null se non trovato
	 */
    function get_utente_admin() {
		return Utente::from_id($this->admin_id);
    }

	/**
	 * Ottieni la lista di inviti attivi della fantalega.
	 * @return null|Invito[] lista di inviti attivi della fantalega, null se non trovata
	 */
	function get_inviti_attivi() {
		return Invito::get_inviti_fantalega($this->fantalega_id);
	}

	function get_fantasquadre() {
		$conn = Database::get_connection();
		if (!$conn) {
			return null;
		}

		$sql = "SELECT fantasquadre.fantasquadra_id AS fantasquadra_id".
		       " FROM fantasquadre".
			   " WHERE fantasquadre.fantalega_id = $this->fantalega_id";
		$query = $conn->query($sql);
		if (!$query) {
			return null;
		}

		$fantasquadre = array();
		while ($fantasquadra = $query->fetch_assoc()) {
			$fantasquadre[] = Fantasquadra::from_id($fantasquadra["fantasquadra_id"]);
		}

		$conn->close();

		return $fantasquadre;
	}

	static function crea_fantalega($nome, $admin_id) {
		$conn = Database::get_connection();
		if (!$conn) {
			return null;
		}

		$sql = "INSERT INTO fantaleghe (nome, admin_id) VALUES ('$nome', $admin_id)";
		$query = $conn->query($sql);
		if (!$query) {
			return null;
		}

		$fantalega_id = $conn->insert_id;

		$conn->close();

		return new Fantalega(
			$fantalega_id,
			$nome,
			$admin_id
		);
	}

	static function from_id($fantalega_id) {
		$conn = Database::get_connection();
		if (!$conn) {
			return null;
		}

		$sql = "SELECT * FROM fantaleghe WHERE fantalega_id = $fantalega_id";
		$query = $conn->query($sql);
		if (!$query) {
			return null;
		}

		$fantalega = $query->fetch_assoc();

		$conn->close();

		return new Fantalega(
			$fantalega["fantalega_id"],
			$fantalega["nome"],
			$fantalega["admin_id"]
		);
	}

	/**
	 * elimina la fantalega dal database
	 */
	function elimina() {
		$conn = Database::get_connection();
		if (!$conn) {
			return false;
		}

		$sql = "DELETE FROM fantaleghe WHERE fantalega_id = $this->fantalega_id";
		$query = $conn->query($sql);
		if (!$query) {
			return false;
		}

		$conn->close();

		return true;
	}
}
?>
