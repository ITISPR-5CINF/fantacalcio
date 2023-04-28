<?php
class Database {
    private $host = "localhost";
    private $user = "fantacalcio";
    private $password = "fantacalcio";
    private $db = "fantacalcio";

    static function get_connection() {
        $db = new Database();
        $conn = new mysqli($db->host, $db->user, $db->password, $db->db);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        return $conn;
    }
}
?>
