<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
// include database and object files
include_once '../config/database.php';
include_once '../objetos/planeta.php';
 
// instantiate database and product object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$planeta = new Planeta($db);
 
// get keywords
$keywords=isset($_GET["s"]) ? $_GET["s"] : "";
 
// query products
$stmt = $planeta->search($keywords);
$num = $stmt->rowCount();
 
// check if more than 0 record found
if($num>0){
 
    // products array
    $planetas_arr=array();
    $planetas_arr["planeta"]=array();
 
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
            "terreno" => $terreno,
        );
 
        array_push($planetas_arr["planeta"], $planeta_atributos);
    }
 
    echo json_encode($planetas_arr);
}
 
else{
    echo json_encode(
        array("message" => "Nenhum planeta encontrado, você está sozinho no espaço.")
    );
}
?>