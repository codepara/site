<?php
require_once("../config.php");
/**
 * Conexão Simples com PDO
 */
class Conexao {
	
	static private $instance;
	
	private function __Construct(){}
	
	public static function getInstance()
	{
		if(!isset(self::$instance)):
			self::$instance = new PDO("firebird:dbname=192.168.0.102:/banco/projeto/admjanelaunica.fdb","SYSDBA","masterkey");
		endif;
		return self::$instance;
	}

 /*	public static function getInstance(){
		try {
			if(!isset(self::$instance))
				self::$instance = new PDO("firebird:dbname=192.168.0.102:/banco/projeto/admjanelaunica.fdb","SYSDBA","masterkey");
			
			return self::$instance;
		}
		catch(PDOException $e){
			echo "Erro ao conectar: ".$e->getMessage();
		}
		//192.168.0.102:/var/www/banco/projeto/admjanelaunica.fdb
		// – new PDO(“firebird:dbname=C:\\nomeBase.DB”, “SYSDBA”, “masterkey”);
	}
*/
}
$con = Conexao::getInstance();
var_dump($con);
//echo $con == TRUE ? "Conectado" : "Falha na conexão";