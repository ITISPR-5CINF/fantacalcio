<?php
/**
 * Classe astratta per tutti i modelli
 */
abstract class Base {
    public function to_json() {
        return json_encode($this);
    }
}
?>
