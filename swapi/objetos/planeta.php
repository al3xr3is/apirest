<?php 

	class Planeta{

		//atributos de conexão ao banco de dados e tabela
		private $conn;
		private $table_name = "planetas";
		//atributos do objeto Planeta
		public $id;
		public $nome;
		public $clima;
		public $terreno;
		//construtor $db com conexão ao banco de dados
		public function __construct($db)
		{
			$this->conn = $db;
		}
		//metodos acessores

		public function getTableName()
		{
			return $this->table_name;
		}

		public function getConn()
		{
			return $this->conn;
		}

		public function getId()
		{
			return $this->id;
		}

		public function getNome()
		{
			return $this->nome;
		}

		public function getClima()
		{
			return $this->clima;
		}

		public function getTerreno()
		{
			return $this->terreno;
		}

		public function setId($id)
		{
			$this->id = $id;
		}

		public function setNome($nome)
		{
			$this->nome = $nome;
		}

		public function setClima($clima)
		{
			$this->nome = $clima;
		}

		public function setTererno($terreno)
		{
			$this->nome = $terreno;
		}
		//faz a leitura do planeta e exibe na tela
		public function read(){
 
    		// select all query
    		$query = "SELECT id, nome, clima, terreno FROM ". $this->table_name . " ";
    		// prepare query statement
    		$stmt = $this->conn->prepare($query); 
    		// execute query
    		$stmt->execute(); 
    		return $stmt;
		}
		//metodo para criar planetas
		public function create()
		{
			// query para inserir dados
			$query = "INSERT INTO " .$this->table_name . "
			SET
				id=:id, nome=:nome, clima=:clima, terreno=:terreno";
			//preparando a query
			$stmt = $this->conn->prepare($query);

			//essa é a parte chata, limpando os valores
			$this->id=htmlspecialchars(strip_tags($this->id));
    		$this->nome=htmlspecialchars(strip_tags($this->nome));
    		$this->clima=htmlspecialchars(strip_tags($this->clima));
    		$this->terreno=htmlspecialchars(strip_tags($this->terreno));

    		//amarrando esses valores com bindParam
    		$stmt->bindParam(":id", $this->id);
    		$stmt->bindParam(":nome", $this->nome);
    		$stmt->bindParam(":clima", $this->clima);
    		$stmt->bindParam(":terreno", $this->terreno);
    		
    		//executando a query
    		if($stmt->execute())
    		{
    			return TRUE;
    		}
    			return FALSE;
		}

		// used when filling up the update product form
		function readOne(){
 
    		// query to read single record
    		$query = "SELECT id, nome, clima, terreno FROM ". $this->table_name . "
            	WHERE
                	id = ?
            	LIMIT
                	0,1";
 
    		// prepare query statement
    		$stmt = $this->conn->prepare( $query );
 
    		// bind id of product to be updated
    		$stmt->bindParam(1, $this->id);
 
    		// execute query
    		$stmt->execute();
 
    		// get retrieved row
    		$row = $stmt->fetch(PDO::FETCH_ASSOC);
 
    		// set values to object properties
    		$this->id = $row['id'];
    		$this->nome = $row['nome'];
    		$this->clima = $row['clima'];
    		$this->terreno = $row['terreno'];
		}

		// update the product
		public function update()
		{ 
    		// update query
    		$query = "UPDATE
                	" . $this->table_name . "
            	SET
              	  nome = :nome,
                	clima = :clima,
               	 terreno = :terreno,
            	WHERE
                	id = :id";
 
	    	// prepare query statement
	    	$stmt = $this->conn->prepare($query);
	 
	    	// sanitize
	    	$this->nome=htmlspecialchars(strip_tags($this->nome));
	    	$this->clima=htmlspecialchars(strip_tags($this->clima));
	    	$this->terreno=htmlspecialchars(strip_tags($this->terreno));
	    	$this->id=htmlspecialchars(strip_tags($this->id));
	 
	    	// bind new values
	    	$stmt->bindParam(':nome', $this->nome);
	    	$stmt->bindParam(':clima', $this->clima);
	    	$stmt->bindParam(':terreno', $this->terreno);
	    	$stmt->bindParam(':id', $this->id);
	 
	    	// execute the query
	    	if($stmt->execute()){
	        	return true;
    		}
    			return false;
		}

		// delete the product
		function delete(){
		 
		    // delete query
		    $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
		 
		    // prepare query
		    $stmt = $this->conn->prepare($query);
		 
		    // sanitize
		    $this->id=htmlspecialchars(strip_tags($this->id));
		 
		    // bind id of record to delete
		    $stmt->bindParam(1, $this->id);
		 
		    // execute query
		    if($stmt->execute()){
		        return true;
		    }
		    	return false; 
		}

		// search products
		public function search($keywords){
		 
		    // select all query
		    $query = "SELECT
		                id, nome, clima, terreno
		            FROM
		                " . $this->table_name . "
		            WHERE
		                nome LIKE ? OR clima LIKE ? OR terreno LIKE ?
		            ORDER BY
		                id DESC";
		 
		    // prepare query statement
		    $stmt = $this->conn->prepare($query);
		 
		    // sanitize
		    $keywords=htmlspecialchars(strip_tags($keywords));
		    $keywords = "%{$keywords}%";
		 
		    // bind
		    $stmt->bindParam(1, $keywords);
		    $stmt->bindParam(2, $keywords);
		    $stmt->bindParam(3, $keywords);
		 
		    // execute query
		    $stmt->execute();
		 
		    return $stmt;
		}

		// read products with pagination
		public function readPaging($from_record_num, $records_per_page){
		 
		    // select query
		    $query = "SELECT
		                id, nome, clima, terreno
		            FROM
		                " . $this->table_name . "		                	
		            ORDER BY id DESC
		            LIMIT ?, ?";
		 
		    // prepare query statement
		    $stmt = $this->conn->prepare( $query );
		 
		    // bind variable values
		    $stmt->bindParam(1, $from_record_num, PDO::PARAM_INT);
		    $stmt->bindParam(2, $records_per_page, PDO::PARAM_INT);
		 
		    // execute query
		    $stmt->execute();
		 
		    // return values from database
		    return $stmt;
		}

		// used for paging products
		public function count(){
		    $query = "SELECT COUNT(*) as total_rows FROM " . $this->table_name . "";
		 
		    $stmt = $this->conn->prepare( $query );
		    $stmt->execute();
		    $row = $stmt->fetch(PDO::FETCH_ASSOC);
		 
		    return $row['total_rows'];
		}
}
 ?>