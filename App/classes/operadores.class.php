<?Php
require_once(dirname(__FILE__)."/autoload.php");
protegeArquivo(basename(__FILE__));
	class operadores extends base{
		public function __construct($campo=array()){
			parent::__construct(); //metodo da classe mãe (base) com a conexao
			$this->tabela = 'OPERADORES';
			if(sizeof($campo)<=0):
				$this->campos_valores = array(
					"DESCRICAO" => NULL,
					"LOGIN" => NULL,
					"SENHA" => NULL,
					"SITUACAO" => NULL,
					"SESSAO" => NULL,
				);
			else:
				$this->campos_valores = $campo;
			endif;
			$this->campopk = 'CODIGO';
		}// Fim do construct
		//Funcao para realizar o LOGIN
		public function doLogin($objeto){
			$objeto->extras_select = "WHERE login='".$objeto->getValor('login')."' AND senha='".codificaSenha($objeto->getValor('senha'))."' AND ativo='s'";
			$this->selecionaTudo($objeto);
			$sessao = new sessao();
			if($this->linhasafetadas==1):
				$usLogado = $objeto->retornaDados();
				$sessao->setVar('iduser', $usLogado->id);
				$sessao->setVar('nomeuser', $usLogado->nome);
				$sessao->setVar('loginuser', $usLogado->login);
				$sessao->setVar('logado', TRUE);
				$sessao->setVar('ip', $_SERVER['REMOTE_ADDR']);
				return TRUE;
			else:
				$sessao->destroy(TRUE);
				return FALSE;
			endif;
		}//Fim function LOGIN
		//Function para sair do Sistema
		public function doLogout(){
			$sessao = new sessao();
			$sessao->destroy(TRUE);
			redireciona('?erro=1');
		}
		//Verificar Login ou Email cadastrados
		public function existeRegistro($campo=NULL, $valor=NULL){
			if($campo!=NULL && $valor!=NULL):
				is_numeric($valor) ? $valor=$valor : $valor="'".$valor."'";
				$this->extras_select = "WHERE $campo=$valor";
				$this->selecionaTudo($this);
				if($this->linhasafetadas > 0):
					return TRUE;
				else:
					return FALSE;
				endif;
			else:
				$this->trataerro(__FILE__, __FUNCTION__, NULL,'Faltam parametros para executar a funcao', TRUE);
			endif;
		}
	}//Fim da Classe Clientes
?>