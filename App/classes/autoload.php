<?Php
//Classe para carregar as classes pelo nome do arquivo
$pathlocal = dirname(__FILE__);
require_once(dirname($pathlocal)."/funcoes.php");
protegeArquivo(basename(__FILE__));
function __autoload($classe){
	$classe = str_replace('..', '', $classe);
	//echo $pathlocal."$classe.class.php";
	//exit;
	//require_once($pathlocal."$classe.class.php");
	require_once("$classe.class.php");
}