<?Php
require_once(dirname(__FILE__)."/autoload.php");
protegeArquivo(basename(__FILE__));
	class menu extends base{
		public function __construct(){
			parent::__construct(); //metodo da classe mãe (base) com a conexao
		}// Fim do construct

		// Seleciona Menu Principal
		public function topMenu($objeto){
			$this->addCampo('CODIGO');
			$this->addCampo('DESCRICAO');
			$this->addCampo('CAMINHOPAGINA');
			$this->addCampo('CODIGOSPERMISSOES');
			$this->addCampo('TIPOSPERMISSOES');
			$this->tabela = 'MENUITENS';
			$this->selecionaCampos($objeto);
			$resObjeto = $this->retornaDados();
			return $resObjeto;
		}
	}//Fim da Classe INICIO