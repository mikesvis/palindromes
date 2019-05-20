<?php
require_once('../vendor/autoload.php');
header("Content-Type: application/json");

use TestPoly\SearchPalindromes;
use TestPoly\SearchController;

$params = $_GET ?? null;

$finder = new SearchController(new SearchPalindromes($params));

if($finder->validate()){
	$response = $finder->doSearching()->getResult();
} else {
	http_response_code(422);
	$response = $finder->getErrors();
}

echo json_encode($response);