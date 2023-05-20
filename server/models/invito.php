<?php
require_once "base.php";
require_once __DIR__."/../database/database.php";

/**
 * Classe che rappresenta un invito ad una fantalega.
 */
class Invito extends Base {
	public $utente_id;
	public $fantalega_id;

	function __construct($utente_id, $fantalega_id) {
		$this->utente_id = $utente_id;
		$this->fantalega_id = $fantalega_id;
	}

	/**
	 * Restituisce tutte gli inviti.
	 */
	static function get_all() {
		$conn = Database::get_connection();
		if (!$conn) {
			return null;
		}

		$sql = "SELECT *".
		       " FROM inviti";
		$query = $conn->query($sql);
		if (!$query) {
			return null;
		}

		$inviti = array();
		while ($row = $query->fetch_assoc()) {
			$inviti[] = new Invito(
				$row['utente_id'],
				$row['fantalega_id']
			);
		}

		$conn->close();

		return $inviti;
	}

	static function get_inviti_utente($utente_id) {
		$utente_id = intval($utente_id);

		$conn = Database::get_connection();
		if (!$conn) {
			return null;
		}

		$sql = "SELECT *".
		       " FROM inviti".
		       " WHERE inviti.utente_id = $utente_id";
		$query = $conn->query($sql);
		if (!$query) {
			return null;
		}

		$inviti = array();
		while ($row = $query->fetch_assoc()) {
			$inviti[] = new Invito(
				$row['utente_id'],
				$row['fantalega_id']
			);
		}

		$conn->close();

		return $inviti;
	}

	static function get_inviti_fantalega($fantalega_id) {
		$fantalega_id = intval($fantalega_id);

		$conn = Database::get_connection();
		if (!$conn) {
			return null;
		}

		$sql = "SELECT *".
		       " FROM inviti".
		       " WHERE inviti.fantalega_id = $fantalega_id";
		$query = $conn->query($sql);
		if (!$query) {
			return null;
		}

		$inviti = array();
		while ($row = $query->fetch_assoc()) {
			$inviti[] = new Invito(
				$row['utente_id'],
				$row['fantalega_id']
			);
		}

		$conn->close();

		return $inviti;
	}

	static function crea_invito($utente_id, $fantalega_id) {
		$utente_id = intval($utente_id);
		$fantalega_id = intval($fantalega_id);

		$conn = Database::get_connection();
		if (!$conn) {
			return null;
		}

		$sql = "INSERT INTO inviti (utente_id, fantalega_id) VALUES ($utente_id, $fantalega_id)";
		$query = $conn->query($sql);
		if (!$query) {
			return null;
		}

		$conn->close();

		return new Invito(
			$utente_id,
			$fantalega_id
		);
	}
}
?>
