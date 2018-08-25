<?php 
// headers necessários
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

//inclusão do banco de dados e arquivo dos objetos
include_once '../config/database.php';
include_once '../objetos/planeta.php';

//instanciando o banco de dados e o objeto planeta
$database = new Database();
$db = $database->getConnection();

//iniciando o objeto planeta
$planeta = new Planeta($db);

//busca planetas
$stmt = $planeta->read();
$num = $stmt->rowCount();
//checando se mais de 0 resultados encontrados
if ($num > 0)
{
	//vetor de planetas ;)
	$planetas_arr = array();
	$planetas_arr["Planetas"] = array();

	//retornando o conteudo da tabela
	//"lembrete" fetch() é mais rapido que fetchAll() boas práticas sempre ;)
	while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
	{
		//extraindo row
		// isso fará com que $row['name'] para somente $name
		extract($row);

		$planeta_atributos = array(
			"id" => $id,
			"nome" => $nome,
			"clima" => $clima,
			"terreno" => $terreno
		);

		array_push($planetas_arr["Planetas"], $planeta_atributos);
	}

	echo json_encode($planetas_arr);
 }

 	else
 	{
 		echo json_encode(array("mensagem" => "nenhum planeta encontrado."));
 	}
 ?>
