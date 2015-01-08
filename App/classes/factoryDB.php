<?php
require_once("../config.php");
ini_set('display_errors', 1);

//--->	Conexão Factory com os 2 bancos
class FactoryDB {
	
	//private $strHost;
	
	//$Key: Codigo de alguma Prefeitura (int)
	public static function factoryCon($key=null){
		if( isset($key) || $key != null ){
			if(!is_int($key))
				$key = (int)$key;
			//echo $key;
			$str = getHostin($key);
			var_dump($key);
			return ConexaoPREF::conPREF($result['PATHBASEDADOS']);
		}
		return ConexaoADM::getInstance();//Conexão com o BD ADM
	}
	
	private function setHost(String $host){
		$this->strHost = $host;
	}

	private function getHostin($key){
		echo "Dentro da getHost key: ".$key;
		$conn = ConexaoADM::getInstance();
		$query = $conn->prepare("SELECT PATHBASEDADOS FROM PREFEITURAS WHERE CODIGO = $key");
		//$query->bindParam(":key", $key);
		$query->execute();
		$result = $query->fetch();
		return $result['PATHBASEDADOS'];
	}

}

//--->	Conexão com ADM JANELAUNICA
class ConexaoADM {

	private static $instanceAdm;
	
	private function __construct() {}
	
	public static function getInstance()
	{
		if(!isset(self::$instanceAdm)):

			try {
				self::$instanceAdm = new PDO("firebird:dbname=localhost:/var/www/banco/admjanelaunica.fdb","SYSDBA","masterkey");
			}
			catch(PDOException $e){
				echo "Erro ao conectar: ".$e->getMessage();
			}
		endif;
		return self::$instanceAdm;
	}
}

/**
 * Conexão com JANELAUNICA
 */
class ConexaoPREF {
	
	private static $instancePref;
	
	private function __construct() {}
	
	public static function getInstance($strHost)
	{
		if(!isset(self::$instancePref)):

			try {
				echo $strHost."Host da Prefeitura";
				self::$instancePref = new PDO("firebird:dbname='".$strHost."','SYSDBA','masterkey'");
			}
			catch(PDOException $e){
				echo "Erro ao conectar: ".$e->getMessage();
			}
		endif;
		return self::$instancePref;
	}
};

//$admin = FactoryDB::factoryCon();
//echo DBHOST."<br >";
//var_dump($admin);

$admin = FactoryDB::factoryCon( 1 );
//var_dump($admin);



