<?php

require "base.php";
require __DIR__."/../database/database.php";

/**
 * Classe che rappresenta una squadra di Serie A TIM.
 */
class Squadra implements Base {
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

    function to_json() {
        return json_encode($this);
    }

    /**
     * Restituisce una squadra dato il suo id.
     * @param $squadra_id id della squadra da cercare
     * @return null|Squadra squadra trovato, null se non trovata
     */
    static function from_id($squadra_id) {
        $squadra_id = intval($squadra_id);

        $conn = Database::get_connection();
        if ($conn->connect_error) {
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
}
?>
