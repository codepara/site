<?Php
require_once(dirname(__FILE__)."/autoload.php");
protegeArquivo(basename(__FILE__));
	abstract class base extends banco{
		//Criar Propriedades da classe BASE
		public $tabela = ""; //Setar a tabela a ser manipulada
		public $campos_valores = array(); //campos e valores da tabela em array
		public $campopk = NULL; // Campo Primary key
		public $valorpk = NULL;// Valor do campo primary key
		public $extras_select = ""; //extras dos selects; order by, limit, etc.
		//Metodos da classe
		public function addCampo($campo=NULL, $valor=NULL){
			If($campo!=NULL)
				$this->campos_valores[$campo] = $valor;
		}// Fim da addCampo
		public function delCampo($campo=NULL){
			if(array_key_exists($campo, $this->campos_valores))
				unset($this->campos_valores[$campo]);
		}// Fim da função delCampo
		public function setValor($campo=NULL, $valor=NULL){
			if($campo!=NULL && $valor!=NULL)
				$this->campos_valores[$campo] = $valor;
		}// FIm da função setValor
		public function getValor($campo=NULL){
			if($campo!=NULL && array_key_exists($campo, $this->campos_valores)):
				return $this->campos_valores[$campo];
			else:
				return FALSE;
			endif;
		}
	}