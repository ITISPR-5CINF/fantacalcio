<?php

require_once "base.php";
require_once __DIR__."/../database/database.php";

/**
 * Classe che rappresenta un giocatore di una squadra.
 */
class Giocatore implements Base {
    public $giocatore_id;
    public $cognome_nome;
    public $data_nascita;
    public $posizione;
    public $crediti_iniziali;
    public $crediti_finali;
    public $squadra_id;
    public $nazionalita;

    function __construct($giocatore_id, $cognome_nome, $data_nascita, $posizione, $crediti_iniziali, $crediti_finali, $squadra_id, $nazionalita) {
        $this->giocatore_id = $giocatore_id;
        $this->cognome_nome = $cognome_nome;
        $this->data_nascita = $data_nascita;
        $this->posizione = $posizione;
        $this->crediti_iniziali = $crediti_iniziali;
        $this->crediti_finali = $crediti_finali;
        $this->squadra_id = $squadra_id;
        $this->nazionalita = $nazionalita;
    }

    function to_assoc_array() {
        return array(
            "giocatore_id" => $this->giocatore_id,
            "cognome_nome" => $this->cognome_nome,
            "data_nascita" => $this->data_nascita,
            "posizione" => $this->posizione,
            "crediti_iniziali" => $this->crediti_iniziali,
            "crediti_finali" => $this->crediti_finali,
            "squadra_id" => $this->squadra_id,
            "nazionalita" => $this->nazionalita,
        );
    }

    function to_json() {
        return json_encode(to_assoc_array());
    }

    /**
     * Restituisce un giocatore dato il suo id.
     * @param $giocatore_id id del giocatore da cercare
     * @return null|Giocatore giocatore trovato, null se non trovato
     */
    static function from_id($giocatore_id) {
        $giocatore_id = intval($giocatore_id);

        $conn = Database::get_connection();
        if ($conn->connect_error) {
            return null;
        }

        $sql = "SELECT * FROM giocatori WHERE giocatori.giocatore_id = $giocatore_id";
        $query = $conn->query($sql);
        if (!$query) {
            return null;
        } else if ($query->num_rows == 0) {
            return null;
        } else if ($query->num_rows > 1) {
            // ??
            return null;
        }

        $giocatore = $query->fetch_assoc();

        // Ottieni le nazionalità del giocatore
        $sql = "SELECT nazione FROM nazionalita_giocatori WHERE nazionalita_giocatori.giocatore_id = $giocatore_id";
        $query = $conn->query($sql);
        if (!$query) {
            return null;
        }

        $nazionalita = array();
        while ($row = $query->fetch_assoc()) {
            $nazionalita[] = $row['nazione'];
        }

        $conn->close();

        return new Giocatore(
            $giocatore['giocatore_id'],
            $giocatore['cognome_nome'],
            $giocatore['data_nascita'],
            $giocatore['posizione'],
            $giocatore['crediti_iniziali'],
            $giocatore['crediti_finali'],
            $giocatore['squadra_id'],
            $nazionalita
        );
    }

    static function get_all() {
        $conn = Database::get_connection();
        if ($conn->connect_error) {
            return null;
        }

        $sql = "SELECT * FROM giocatori";
        $query = $conn->query($sql);
        if (!$query) {
            return null;
        }

        $giocatori = array();
        while ($row = $query->fetch_assoc()) {
            $giocatori[] = Giocatore::from_id($row['giocatore_id']);
        }

        $conn->close();

        return $giocatori;
    }
}
?>
