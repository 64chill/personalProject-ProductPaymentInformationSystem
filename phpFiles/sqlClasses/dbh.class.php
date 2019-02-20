<?php
//PDO DB access
/**
* class Dbh
*   public function 	connect()
*		public function 	getLastRecordID()
*
*
*/
class Dbh{
	private $servername;
	private $username;
	private $password;
	private $dbname;
	private $charset;
	private $pdo;


	public function connect(){
		$this->servername	=	"localhost";
		$this->username 	=	"root";
		$this->password 	=	"";
		$this->dbname 		=	"np";
		$this->charset 		=	"utf8mb4";

//---------------------------------------------------try
		try{
//data source name
		$dsn =
		"mysql:host=".$this->servername.
		";dbname=".$this->dbname.
		";charset=".$this->charset;

//PDO conn
		$this->pdo = new PDO($dsn, $this->username, $this->password);
//PDO exception
		$this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		return $this->pdo;
//------------------------------------------------catch
		} catch(PDOException $e){

			$file="errlog.txt";

			$txt =date("Y-m-d"). " | ".
			date("h:i:sa").
			"Konekcija ka bazi neuspešna ".
			$e->getMessage()."\n";

			file_put_contents($file, $txt, FILE_APPEND | LOCK_EX);//or ...
			exit();

		}

	} // end connect
	public function getLastRecordID(){
		return $this->pdo->lastInsertId();
	}
} // class Dbh end
// da se napravi konekcija ka bazi  instanciranje objekta = $object
?>
