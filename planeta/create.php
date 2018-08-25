<?php 
// cabeçalhos necessários
header("multipart/form-data-encoded");
header("application/x-www-form-urlencoded");
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// pegando a conexão do banco de dados e da classe planeta
include_once '../config/database.php';
include_once '../objetos/planeta.php';

//instanciando o banco de dados e a classe Planeta
$database = new Database();
$db = $database->getConnection();

$planeta = new Planeta($db);

//pegando a informação
$data = json_decode(file_get_contents("php://input", true));

// setando os valores dos atributos planeta
$planeta->id = $data->id;
$planeta->nome = $data->nome;
$planeta->clima = $data->clima;
$planeta->terreno = $data->terreno;

// criando planeta
if($planeta->create())
{
	echo '{';
		echo '"mensagem": "planeta foi criado com sucesso!"';
	echo '}';
}
else
{
	echo '{';
		echo '"mensagem": "Não foi possível criar o planeta ;( "';
	echo '}';
}
 ?>