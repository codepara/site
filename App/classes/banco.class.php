<?Php
require_once(dirname(__FILE__)."/autoload.php");
protegeArquivo(basename(__FILE__));

abstract class banco{
	//Propriedades  da Classe
	private $servidor 		= DBHOST;
	private $usuario 		= DBUSER;
	private $senha 			= DBPASS;
	private $conexao 		= NULL;
	private $dataset 		= NULL;
	private $linhasafetadas = -1;
	//Criação dos Métodos

	//Criar Método Construtor com a conexão
	public function __construct(){
		$this->conecta(); // chama metodo conecta
	}//fim do metodo construtor

	public function __desctruct(){
		if($this->conexao != NULL): //se houver uma conexao
			ibase_close($this->conexao); // encerro a conexao
		endif;
	}//fim metodo DESTRUCT

	//Função para conectar ao banco de dados
	public function conecta(){
		$this->conexao = ibase_connect($this->servidor, $this->usuario, $this->senha)
		or die( $this->trataerro(__FILE__, __FUNCTION__, ibase_errcode(), ibase_errmsg(), FALSE ));
	}//fim function conecta

	//Funcao para Inserir Dados
	public function inserir($objeto){
		$sql = "INSERT INTO ".$objeto->tabela." ("; //Iniciando a montagem do SQL
		for($i=0;$i < count($objeto->campos_valores);$i++): //Percorrer os campos do SQL
			$sql .= key($objeto->campos_valores); //Inserindo os Campos
			if($i < (count($objeto->campos_valores) - 1)): //Verifica ultimo campo para não inerir virgula
				$sql .= ", ";
			else:
				$sql .= ") ";
			endif;
			next($objeto->campos_valores); //Necessário para ir no próximo Campo
		endfor;
		reset($objeto->campos_valores); //Resetando o objeto para voltar ao ponteiro inicial
		$sql .= "VALUES (";
		for($i=0;$i < count($objeto->campos_valores);$i++): //Percorrer os Values do SQL
			$sql .= is_numeric($objeto->campos_valores[key($objeto->campos_valores)]) ?	//Verifica se o valor é Numerico
					$objeto->campos_valores[key($objeto->campos_valores)] :				//Para inserir ou não aspas
					"'".$objeto->campos_valores[key($objeto->campos_valores)]."'"; 		//condição Ternária: Inserindo os VALUES
			if($i < (count($objeto->campos_valores) - 1)): //Verifica ultimo campo para não inerir virgula
				$sql .= ", ";
			else:
				$sql .= ");";
			endif;
			next($objeto->campos_valores); //Necessário para ir no próximo Campo
		endfor;
		return $this->queryProcedure($sql);
	}//Fim function Inserir

	// FUNCAO ATUALIZAR DADOS
	public function atualizar($objeto){
		$sql = "UPDATE ".$objeto->tabela." SET ";
		for($i=0;$i<count($objeto->campos_valores);$i++):
			$sql .= key($objeto->campos_valores)."=";
			$sql .= is_numeric($objeto->campos_valores[key($objeto->campos_valores)]) ?
			$objeto->campos_valores[key($objeto->campos_valores)] :
			"'".$objeto->campos_valores[key($objeto->campos_valores)]."'";
			if($i<(count($objeto->campos_valores)-1)):
				$sql .= ", ";
			else:
				$sql .= " ";
			endif;
			next($objeto->campos_valores);
		endfor;
		$sql .= "WHERE ".$objeto->campopk."=";
		$sql .= is_numeric($objeto->valorpk) ? $objeto->valorpk : "'".$objeto->valorpk."'";
		return $this->executaSQL($sql);
	}//Fim da function Atualiza

	//FUNCAO DELETAR DADOS
	public function deletar($objeto){
		//Delete from tabela where id = valorid
		$sql = "DELETE FROM ".$objeto->tabela." WHERE ".$objeto->campopk."=";
		$sql .= is_numeric($objeto->valorpk) ? $objeto->valorpk : "'".$objeto->valorpk."'";
		return $this->executaSQL($sql);
	}// fim function DELETAR dados

	//FUNCAO PARA SELECIONAR TODOS OS DADOS DA JQUERY
	public function selecionaTudo($objeto){
		$sql = "SELECT * FROM ".$objeto->tabela;
		if($objeto->extras_select != NULL):
			$sql .= " ".$objeto->extras_select;
		endif;
		return $this->executaSQL($sql);
	}// Fim da function SLECIONA TUDO

	// FUNCAO SELECIONA CAMPOS
	public function selecionaCampos($objeto){
		$sql = "SELECT ";
		for($i=0;$i<count($objeto->campos_valores);$i++):
			$sql .= key($objeto->campos_valores);
			if($i < (count($objeto->campos_valores)-1)):
				$sql .= ", ";
			else:
				$sql .= " ";
			endif;
			next($objeto->campos_valores);
		endfor;
		$sql .= " FROM ".$objeto->tabela;
		if($objeto->extras_select != NULL):
			$sql .= " ".$objeto->extras_select;
		endif;
		//echo 'Seleciona Campos '.$sql;
		return $this->executaSQL($sql);
	}// Fim function SELCIONA CAMPOS
	//Funcao para Executar Procedures
	/*
	Os campos passados devem ser já com os valores, e não com as variáveis
	Pois a procedure já terá que ser carregada com os valores dos atributos e não com as variáveis.
	*/
	public function executaProcedure($objeto){
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
			next( $objeto->campos_valores ); 	//Necessário para ir no próximo Campo
		endfor;
		return $this->queryProcedure( $sql );
	}

	//Funcao para Executar PROCEDURE
	public function queryProcedure($sql=NULL){
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

	//Funcao para Executar SQL
	public function executaSQL($sql=NULL){
		if($sql!=NULL):
			$trans = ibase_trans(IBASE_DEFAULT,$this->conexao);// Abre uma transação com o Banco
			$query = ibase_query($sql) or $this->trataerro(__FILE__, __FUNCTION__); //Executa o SQL passado por parâmentro
			$this->linhasafetadas = ibase_affected_rows($this->conexao); //Verifica o numero de linas retornadas
			ibase_commit($trans);
			if(substr(trim(strtolower($sql)),0,6) == "select"):
				$this->dataset = $query;
				return $this->dataset;
			else:
				return $this->linhasafetadas;
			endif;
		else:
			$this->trataerro(__FILE__,__FUNCTION__,NULL,'SQL não foi informado.',FALSE);
		endif;
	}// Fim function EXECUTASQL

	//FUNTION PARA RETORNAR DADOS DO QUERY
	public function retornaDados($tipo=NULL){
		switch(strtolower($tipo)):
			case "array":
				return ibase_fetch_array($this->dataset);
				break;
			case "assoc":
				return ibase_fetch_assoc($this->dataset);
				break;
			case "object":
				return ibase_fetch_object($this->dataset);
				break;
			default:
				return ibase_fetch_object($this->dataset);
				break;
		endswitch;
	}//Fim  da FUNCTIN RETORNA DADOS

	//Funcao para Tratar Erros
	public function trataerro($arquivo=NULL, $rotina=NULL, $numerro=NULL, $msgerro=NULL, $geraexcept=TRUE){
		if($arquivo == NULL) $arquivo = 'Arquivo não informado';
		if($rotina == NULL) $rotina = 'Rotina não informada';
		//if($numerro == NULL) $numerro = ibase_errcode($this->conexao);
		//if($msgerro == NULL) $msgerro = ibase_errmsg($this->conexao);
		$resultado = 'Ocorreu um ERRO com seguintes DETALHES:<br />
			<strong>Arquivo</strong>: '.$arquivo.'<br />
			<strong>Rotina</strong>:  '.$rotina.'<br />
			<strong>Codigo</strong>:  '.$numerro.'<br />
			<strong>Mensagem</strong>: '.$msgerro;
		// header("location: erros/500.html");
		if($geraexcept == FALSE):
			// header("location: erros/500.html");
			echo $resultado;
		else:
			die($resultado);
		endif;
		// header("location: erros/500.html");
	}//fim function trataerror

}//fim classe banco
