<?php
class Database {
    private static $host = "localhost";
    private static $user = "fantacalcio";
    private static $password = "fantacalcio";
    private static $db = "fantacalcio";

    static function get_connection() {
        $db = new Database();
        $conn = new mysqli(Database::$host, Database::$user, Database::$password, Database::$db);

        if ($conn->connect_error) {
            return null;
        }

        return $conn;
    }
}
?>
