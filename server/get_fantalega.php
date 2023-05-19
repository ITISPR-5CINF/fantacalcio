<?php
require_once "models/fantalega.php";

if (!isset($_GET['fantalega_id'])) {
	die("No id provided");
}

$fantalega_id = $_GET['fantalega_id'];
$fantalega = Fantalega::from_id($fantalega_id);

if ($fantalega == null) {
	http_response_code(404);
	return;
}

echo $fantalega->to_json();
?>
