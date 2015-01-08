<?php
/*
 * Classe para conexão com a prefeitura;
 * Recebe os parametros da Sessão de Carregamento dos Dados da Prefeitura
 * Criação: 06/02/2014
 * Autor: Hilder Nunes
 * Local: janelaunica/classes/
 * Instanciada no arquivo /janelaunica/6/sistema.php
 * Pagina que roda as outras páginas, por isso ela esta disponivel para todos que incluirem
 */

require_once "../config.php";
ini_set('display_errors', 1);

//--->	Conexão utilizando Singleton
class ConexaoSing {
	
	private static $instance;
	
	private function __construct() {}
	
	public static function getInstance()
	{
		if(!isset(self::$instance)):

			try {
				self::$instance = new PDO("firebird:dbname=localhost:/var/www/banco/admjanelaunica.fdb","SYSDBA","masterkey");
				var_dump( self::$instance );
			}
			catch(PDOException $e){
				echo "Erro ao conectar: ".$e->getMessage();
			}


			//self::$instance = PDO('firebird:dbname=localhost:/var/www/banco/projeto/janelaunica.fdb', DBUSER, DBPASS);
			//var_dump(self::$instance);
			//define(DBHOST, "192.168.0.102:/var/www/banco/projeto/admjanelaunica.fdb");
			//$hostPref = $_SESSION['infoDbPrefeitura']['host'];
			//self::$instance = ibase_connect($hostPref,DBUSER,DBPASS,CHARSET) or die(ibase_errmsg());
		endif;
		return self::$instance;
	}
}
$conSing = ConexaoSing::getInstance();
var_dump($conSing);
echo "dim";
//echo $conSing == TRUE ? "ConexaoSing Ok" : "Conn Fail";
//--->	Para Utilizar esta conexão, basta apenas incluir a classe na pagina e dar o comando abaixo:
//--->	$[ nome da variavel de conexao (qualquer nome) ] = ConexaoSing::getInstance();
