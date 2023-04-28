<?php
require "models/Citta.php";

if (!isset($_GET['id'])) {
    die("No id provided");
}

$id = $_GET['id'];
$citta = Citta::from_id($id);

if ($citta == null) {
    http_response_code(404);
    return;
}

echo $citta->to_json();
?>
