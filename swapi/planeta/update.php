<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// include database and object files
include_once '../config/database.php';
include_once '../objetos/planeta.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare product object
$planeta = new Product($db);
 
// get id of product to be edited
$data = json_decode(file_get_contents("php://input"));
 
// set ID property of product to be edited
$planeta->id = $data->id;
 
// set product property values
$planeta->nome = $data->nome;
$planeta->clima = $data->clima;
$planeta->terreno = $data->terreno;
 
// update the product
if($planeta->update()){
    echo '{';
        echo '"message": "Os dados do planeta foram atualizados."';
    echo '}';
}
 
// if unable to update the product, tell the user
else{
    echo '{';
        echo '"message": "Não foi possível atualizar os dados do planeta."';
    echo '}';
}
?>