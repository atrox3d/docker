<?php

#define('DB_HOST', 'localhost');
#define('DB_HOST', 'elasticsearchphpmysql_mysql_1');
if(!defined('DB_HOST')) define('DB_HOST', getenv( "DB_HOST" )); # docker-compose.yml

#define('DB_USER', 'root');
if(!defined('DB_USER')) define('DB_USER', getenv( "DB_USER" )); # docker-compose.yml

#define('DB_PASSWORD', 'girnar');
#define('DB_PASSWORD', 'p@ssw0rd');
if(!defined('DB_PASSWORD')) define('DB_PASSWORD', getenv( "DB_PASSWORD" )); # docker-compose.yml

#define('DB_DATABASE', 'ecommerce');
if(!defined('DB_DATABASE')) define('DB_DATABASE', getenv( "DB_DATABASE" )); # docker-compose.yml

class Pdodb 
{
	private $host	= DB_HOST;
	private $user	= DB_USER;
	private $pass	= DB_PASSWORD;
	private $dbname	= DB_DATABASE;
	
	private $dsn;
	private $options;
	private $dbh;
	private $error;
	private $stmt;
	
	public function pdoexception($e)
	{
		$this->error = $e->getMessage();
		
		Logger::error("PDO Exception : " 						. PHP_EOL	);
		Logger::error("message       : " . $e->getMessage()		. PHP_EOL	);
		Logger::error("File          : " . $e->getFile()		. PHP_EOL	);
		Logger::error("Line          : " . $e->getLine()		. PHP_EOL	);
		Logger::error("Code          : " . $e->getCode()		. PHP_EOL	);
		Logger::error("Trace         : " 						. PHP_EOL	);
		Logger::error($e->getTraceAsString()					. PHP_EOL	);
			
		Html::pre("Something went wrong with db" . PHP_EOL);
	}
	
	public function errors() {
		if($this->error) {
			return true;
		}
		return false;
	}
	
	public function geterror() {
		return $this->error;
	}
	
	public function __construct()
	{
		$this->dsn	= "mysql:host={$this->host}"
					. ";dbname={$this->dbname}";
					
		$this->options = array(
							PDO::ATTR_PERSISTENT	=> true,
							PDO::ATTR_ERRMODE		=> PDO::ERRMODE_EXCEPTION,
						);
						
		try {
			$this->dbh = new PDO(
									$this->dsn, //error
									$this->user,
									$this->pass,
									$this->options
								);
		}
		catch(PDOException $e) {
			$this->pdoexception($e);
			exit();
		}
	}
	
	public function query($query)
	{
		$this->stmt = $this->dbh->prepare($query);
		return $this;
	}
	
	public function bind($param, $value, $type=null)
	{
		if (is_null($type)) {
			switch (true) {
				case is_int($value):  
					$type = PDO::PARAM_INT;  
				break;  
				
				case is_bool($value):  
					$type = PDO::PARAM_BOOL;  
				break;  
				
				case is_null($value):  
					$type = PDO::PARAM_NULL;  
				break;  
				
				default:  
					$type = PDO::PARAM_STR;  
			}  
		}
		
		$this->stmt->bindValue($param, $value, $type);
		return $this;
	}
	
	public function execute() 
	{
		return $this->stmt->execute();
	}
	
	public function resultset()
	{
		$this->execute();
		return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
		return null;
	}
	
	public function single()
	{
		$this->execute();
		return $this->stmt->fetch(PDO::FETCH_ASSOC);
	}
	
	public function rowCount()
	{
		return $this->stmt->rowCount();
	}
	
	public function lastInsertId()
	{  
		return $this->dbh->lastInsertId();  
	}

	public function beginTransaction()
	{
		return $this->dbh->beginTransaction();  
	}

	public function endTransaction()
	{
		return $this->dbh->commit();  
	}
	
	public function cancelTransaction()
	{  
		return $this->dbh->rollBack();  
	} 	
	
	public function debugDumpParams()
	{
		return $this->stmt->debugDumpParams();  
	}
}







