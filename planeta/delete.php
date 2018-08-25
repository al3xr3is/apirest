<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
 
// include database and object file
include_once '../config/database.php';
include_once '../objetos/planeta.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare product object
$planeta = new Product($db);
 
// get product id
$data = json_decode(file_get_contents("php://input"));
 
// set product id to be deleted
$planeta->id = $data->id;
 
// delete the product
if($planeta->delete()){
    echo '{';
        echo '"message": "O planeta foi excluído, que pena ;( "';
    echo '}';
}
 
// if unable to delete the product
else{
    echo '{';
        echo '"message": "Impossível excluir esse planeta, ele é forte demais para você ;) "';
    echo '}';
}
?>