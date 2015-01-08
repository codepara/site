<?Php
require_once(dirname(__FILE__)."/autoload.php");
protegeArquivo(basename(__FILE__));
	class usuarios extends base{
		public function __construct($campo=array()){
			parent::__construct(); //metodo da classe mãe (base) com a conexao
			$this->tabela = 'VERLOGIN';
			if(sizeof($campo)<=0):
				$this->campos_valores = array(
					"nome" => NULL,
					"email" => NULL,
					"login" => NULL,
					"senha" => NULL,
					"ativo" => NULL,
					"administrador" => NULL,
					"datacad" => NULL,
				);
			else:
				$this->campos_valores = $campo;
			endif;
			$this->campopk = 'id';
		}// Fim do construct
		//Funcao para realizar o LOGIN
		public function doLogin($objeto){
			$logIni = new inicio();
			$logIni->tabela = 'VERLOGIN';
			$logIni->setValor('login', $_GET['login']);
			$logIni->setValor('senha', $_GET['senha']);
			$logIni->setValor('ip', $_SERVER["REMOTE_ADDR"]);
			$logIni->setValor('equipamento', 1);
			$logIni->setValor('plataforma', $_GET['plataforma']);
			$logIni->setValor('browser', $_GET['navegador']);
			$logIni->setValor('versao', $_GET['versao']);
			$logIni->executaDologin($logIni);
			//$sqlconf =  "EXECUTE PROCEDURE VERLOGIN('$login','$senha','$ip',$equipamento,'$plataforma','$browser','$versao');";
			/*
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
			*/
		}//Fim function LOGIN

	public function executaDologin($objeto){
		$sql = "EXECUTE PROCEDURE ".$objeto->tabela." (";
		for($i=0;$i < count($objeto->campos_valores);$i++): //Percorrer os Values do SQL
			$sql .= is_numeric($objeto->campos_valores[key($objeto->campos_valores)]) ?	//Verifica se o valor é Numerico
					$objeto->campos_valores[key($objeto->campos_valores)] :				//Para inserir ou não aspas
					"'".$objeto->campos_valores[key($objeto->campos_valores)]."'"; 		//condição Ternária: Inserindo os VALUES
			if($i < (count($objeto->campos_valores) - 1)): //Verifica ultimo campo para não inerir virgula
				$sql .= ", ";
			else:
				$sql .= ");";
			endif;
			next( $objeto->campos_valores ); //Necessário para ir no próximo Campo
		endfor;
		return $this->queryDologin($sql);
	}
		//Funcao para Executar PROCEDURE LOGIN
		public function queryDologin($sql=NULL){
			if($sql!=NULL):
				$trans = ibase_trans(IBASE_DEFAULT, $this->conexao);// Abre uma transação com o Banco
				$query = ibase_query( $sql ) or die($this->trataerro(__FILE__, __FUNCTION__)); //Executa o SQL passado por parâmentro
				if($query):
					ibase_commit($trans);
					return true;
				else:
					//echo $query;
					//exit;
					$this->linhasafetadas = ibase_affected_rows($this->conexao); //Verifica o numero de linas retornadas
				endif;
			else:
				$this->trataerro(__FILE__,__FUNCTION__,NULL,'SQL não foi informado.',FALSE);
			endif;
		}// Fim function EXECUTASQL
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