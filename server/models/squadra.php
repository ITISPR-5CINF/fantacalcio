<?php

require_once "base.php";
require_once "giocatore.php";
require_once __DIR__."/../database/database.php";

/**
 * Classe che rappresenta una squadra di Serie A TIM.
 */
class Squadra extends Base {
    public $squadra_id;
    public $nome;
    public $citta;
    public $anno_fondazione;

    function __construct($squadra_id, $nome, $citta, $anno_fondazione) {
        $this->squadra_id = $squadra_id;
        $this->nome = $nome;
        $this->citta = $citta;
        $this->anno_fondazione = $anno_fondazione;
    }

    function get_giocatori() {
        $conn = Database::get_connection();
        if (!$conn) {
            return null;
        }

        $sql = "SELECT giocatori.giocatore_id AS giocatore_id FROM giocatori WHERE giocatori.squadra_id = $this->squadra_id";
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

    /**
     * Restituisce una squadra dato il suo id.
     * @param $squadra_id id della squadra da cercare
     * @return null|Squadra squadra trovato, null se non trovata
     */
    static function from_id($squadra_id) {
        $squadra_id = intval($squadra_id);

        $conn = Database::get_connection();
        if (!$conn) {
            return null;
        }

        $sql = "SELECT * FROM squadre WHERE squadre.squadra_id = $squadra_id";
        $query = $conn->query($sql);
        if (!$query) {
            return null;
        } else if ($query->num_rows == 0) {
            return null;
        } else if ($query->num_rows > 1) {
            // ??
            return null;
        }

        $squadra = $query->fetch_assoc();

        $conn->close();

        return new Squadra(
            $squadra["squadra_id"],
            $squadra["nome"],
            $squadra["citta"],
            $squadra["anno_fondazione"]
        );
    }

    static function get_all() {
        $conn = Database::get_connection();
        if (!$conn) {
            return null;
        }

        $sql = "SELECT squadre.squadra_id AS squadra_id FROM squadre";
        $query = $conn->query($sql);
        if (!$query) {
            return null;
        }

        $squadre = array();

        while ($row = $query->fetch_assoc()) {
            $squadre[] = Squadra::from_id($row["squadra_id"]);
        }

        $conn->close();

        return $squadre;
    }
}
?>
