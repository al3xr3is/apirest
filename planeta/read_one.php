<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
 
// include database and object files
include_once '../config/database.php';
include_once '../objetos/planeta.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare product object
$planeta = new Planeta($db);
 
// set ID property of product to be edited
$planeta->id = isset($_GET['id']) ? $_GET['id'] : die();
 
// read the details of product to be edited
$planeta->readOne();
 
// create array
$planeta_arr = array(
    "id" =>  $planeta->id,
    "name" => $planeta->nome,
    "clima" => $planeta->clima,
    "terreno" => $planeta->terreno,
);
 
// make it json format
print_r(json_encode($planeta_arr));
?>