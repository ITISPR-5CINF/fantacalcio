<?php 
require_once "models/squadra.php";

if (!isset($_GET['squadra_id'])) {
    die("No id provided");
}

$squadra_id = $_GET['squadra_id'];
$squadra = Squadra::from_id($squadra_id);

if ($squadra == null) {
    http_response_code(404);
    return;
}

$giocatori = $squadra->get_giocatori();

if ($giocatori == null) {
    http_response_code(500);
    return;
}

print(json_encode(array(
    "success" => true,
    "result" => $giocatori,
)));
?>
