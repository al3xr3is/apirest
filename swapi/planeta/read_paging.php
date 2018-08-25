<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
// include database and object files
include_once '../config/core.php';
include_once '../shared/utilities.php';
include_once '../config/database.php';
include_once '../objetos/planeta.php';
 
// utilities
$utilities = new Utilities();
 
// instantiate database and product object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$planeta = new Planeta($db);
 
// query products
$stmt = $planeta->readPaging($from_record_num, $records_per_page);
$num = $stmt->rowCount();
 
// check if more than 0 record found
if($num>0){
 
    // products array
    $planetas_arr=array();
    $planetas_arr["records"]=array();
    $planetas_arr["paging"]=array();
 
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
 
        $planeta_atributos=array(
            "id" => $id,
            "nome" => $nome,
            "clima" => $clima,
            "terreno" => $terreno
        );
 
        array_push($planetas_arr["records"], $planeta_atributos);
    }
 
 
    // include paging
    $total_rows=$planeta->count();
    $page_url="{$home_url}planeta/read_paging.php?";
    $paging=$utilities->getPaging($page, $total_rows, $records_per_page, $page_url);
    $planetas_arr["paging"]=$paging;
 
    echo json_encode($planetas_arr);
}
 
else{
    echo json_encode(
        array("message" => "Nenhum planeta encontrado, putz que mancada.")
    );
}
?>