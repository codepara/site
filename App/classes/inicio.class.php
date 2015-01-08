<?Php
require_once(dirname(__FILE__)."/autoload.php");
protegeArquivo(basename(__FILE__));
	class inicio extends base{
		public function __construct(){
			parent::__construct(); //metodo da classe mãe (base) com a conexao
		}// Fim do construct

		// Gravar dados da Página e Acesso
		public function gravaIni($objeto){
			//$this->tabela = 'GRAVAVISITA';
			$resGrava->executaProcedure($objeto);
			return $resGrava;
		}

		// Gravar informacao de Click da pagina inicial
		public function gravaClick($objeto){
			$this->tabela = 'BLOCOSLINKSCLIQUES';
			$this->selecionaCampos($objeto);
			return $resClick;
		}

		// Acessar dados de Visitas e Acessos
		public function getAcessos($objeto){
			$this->tabela = 'VERINFORMACOESSISTEMA_1';
			$this->selecionaTudo($objeto);
			$resVerInfo = $objeto->retornaDados();
			return $resVerInfo;
		}

		// Acessar Informacoes da Prefeitura escolhida
		public function getInfoPrefeitura($objeto){
			$this->tabela = 'PREFEITURAS';
			$this->selecionaTudo($objeto);
			$resVerinfo = $objeto->retornaDados();
			return $resVerinfo;
		}

		//Selecionar todas as Prefeituras Cadastradas
		public function getPrefeituras($objeto){
			$this->tabela = '';
			$this->selecionaTudo($objeto);
			$resVerinfo = $objeto->retornaDados();
			return $resVerinfo;
		}

		// Atualizar Informações de Acesso e Visitas
		public function updateVerInfoSis($objeto){
			$this->tabela = 'PREFEITURASDADOSPAINEL';
			$this->campopk = 'CODPREFEITURA';
			$resPainelPref = $this->atualizar($objeto);
		}

		//Selecionar todas as Prefeituras Cadastradas
		public function getArqPrefeitura($objeto){
			$this->tabela = 'PREFEITURASARQUIVOS';
			$this->selecionaTudo($objeto);
			$resArqPref = $objeto->retornaDados();
			return $resArqPref;
		}

		// Fazer o Log de Acesso
		public function doLogin($objeto){
			$this->tabela = 'VERLOGIN';
			$this->selecionaTudo($objeto);
			$resLog = $this->retornaDados();
			return $resLog;
		}

	}//Fim da Classe INICIO