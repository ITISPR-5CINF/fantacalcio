<?php

require "base.php";
require __DIR__."/../database/database.php";

/**
 * Classe che rappresenta una città di una squadra.
 */
class Citta implements Base {
    public $id;
    public $nome;

    function __construct($id, $nome) {
        $this->id = $id;
        $this->nome = $nome;
    }

    function to_json() {
        return json_encode($this);
    }

    static function from_id($id) {
        $id = intval($id);

        $conn = Database::get_connection();
        $sql = "SELECT * FROM citta WHERE citta_id = $id";
        $query = $conn->query($sql);

        if (!$query) {
            return null;
        }

        $citta = $query->fetch_assoc();
        $conn->close();

        return new Citta($citta['citta_id'], $citta['nome']);
    }
}
?>
