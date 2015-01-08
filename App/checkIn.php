<?Php
//Função para Inicializar o Sistema
	//Não recebe parametros, pois verifica se todas as configurações estão
	//definidas e arquivos instalados.
inicializa();
protegeArquivo(basename(__FILE__));

function inicializa(){
	if(file_exists(dirname(__FILE__).'/config.php')):
		require_once(dirname(__FILE__).'/config.php');
	else:
		redireciona('erros/500.html');
		// die(utf8_decode('O ARQUIVO DE CONFIGURA&Ccedil;&Otilde;ES B&Aacute;SICAS não foi encontrado!'));
	endif;
	$constantes = array('BASEPATH','BASEURL','PAINELPATH','SISTEMAPATH','CLASSESPATH','MODULOSPATH','CSSPATH','JSPATH', 'DBHOST', 'DBUSER', 'DBPASS');
	foreach($constantes as $valor):
		if(!defined($valor)):
			die(utf8_decode('PROPRIEDADE B&Aacute;SICA DO SISTEMA AINDA SEM DEFINI&Ccedil;&Atilde;O: file: '.$valor.'!'));
		endif;
	endforeach;
	if( file_exists(BASEPATH.CLASSESPATH.'autoload.php')):
		require_once(BASEPATH.CLASSESPATH.'autoload.php');
	else:
		if(file_exists('erros/500.html')):
			echo 'Erro: CLASSE LOADER não foi encontrada!';
		else:
			echo 'file NOT FOUND!';
		endif;
	endif;
}

//Funcao para carregamento de CSS DINAMICO
function loadCSS($arquivo=NULL, $media='screen', $import=FALSE){
	if($arquivo != NULL):
		if($import==TRUE):
			if(file_exists(BASEURL.CSSPATH.$arquivo.'.css')):
				echo '<style type="text/css">@import url("'.BASEURL.CSSPATH.$arquivo.'.css");</style>'."\n";
			else:
				echo 'Erro: ESTILO não foi encontrado!';
			endif;
			exit;
		else:
			echo '<link type="text/css" rel="stylesheet" media="'.$media.'" href="'.BASEURL.CSSPATH.$arquivo.'.css"/>'."\n";
		endif;
	endif;
}

//Funcao para rodar os JS DINAMICO e REMOTO
function loadJS($arquivo=NULL, $remoto=FALSE){
	if($arquivo != NULL):
		if($remoto == FALSE) $arquivo = BASEURL.JSPATH.$arquivo.".js";
			echo '<script type="text/javascript" src="'.$arquivo.'"></script>'."\n";
	endif;
}

//Funcao para Ler Modulos(páginas).
function loadmodulo($modulo=NULL, $tela=NULL){
	if($modulo==NULL):
		echo '<p>Erro na funcao: <strong>'.__FUNCTION__.'</strong>, Modulo Inexistente.';
	else:
		if(file_exists(MODULOSPATH."$modulo.php")):
			require_once(MODULOSPATH."$modulo.php");
		else:
			redireciona('erros/404.html');
			// echo '<p>Módulo Inexistente.</p>';
		endif;
	endif;
}

//Funcao para proteger o acesso aos Arquivos.
function protegeArquivo($nomeArquivo, $redirPara='erros/403.html'){
	$url = $_SERVER["PHP_SELF"];
	if(preg_match("/$nomeArquivo/i", $url)):
		redireciona($redirPara);
	endif;
}

//funcao para redirecionar para uma URL
function redireciona($url=""){
	header("location: ".BASEURL.$url);
}

//Funcao para Codificar a SENHA
function codificaSenha($senha){
	return md5($senha);
}

function dataHoje($pagina=''){
	$dia_ext = array('domingo','segunda-feira','terça-feira','quarta-feira','quinta-feira','sexta-feira','sábado');
	$mes_ext = array('','janeiro','fevereiro','março','abril','maio','junho','julho','agosto','setembro','outubro','novembro','dezembro');
	$dia_act = $dia_ext[date('w')];
	$mes_act = $mes_ext[date('n')];
	if($pagina == ''):
		$dataStr = '<span class="janela">:: Portal Janela Única - '.$cidadeprefeitura.', '.$dia_act.' '.date('d').' de '.$mes_act.' de '.date('Y').'</span>';
	else:
		$dataStr = '<p>'.ucfirst($dia_act).', '.date('d').' de '.ucfirst($mes_act).' de '.date('Y').'</p>';
	endif;
	return $dataStr;
}
//--->
function comboSelect($nomeId, $typeOpt=NULL, $opt, $codSelect=NULL ){
	if($nomeId != NULL){
		switch($nomeId){
			case 'uf':
			case 'tipoConsAtiv':
				$classe = 'class="pInput"';
				break;
			case 'municipio':
			case 'bairros':
				$classe = 'class="mInput"';
				break;
			case 'logrs':
				$classe = 'class="gInput"';
				break;
		}
		$combo = '<select name="'.$nomeId.'" id="'.$nomeId.'" '.$classe.'>';
		if( $codSelect == NULL ){ $combo .= '<option value="" selected="selected">Selecione</option>'; };
	}
	if($typeOpt == NULL){
		if($nomeId == 'cadMun'){
			while( $res = ibase_fetch_object( $opt ) ){
				if( $res->CODIGO == $codSelect ){
					$combo .= '<option value="'.$res->DESCRICAO.'" selected="selected">'.mb_strtoupper($res->DESCRICAO).'</option>';
				}else{
					$combo .= '<option value="'.$res->DESCRICAO.'">'.mb_strtoupper($res->DESCRICAO).'</option>';
				}
			}
		}else{
			while( $res = ibase_fetch_object( $opt ) ){
				if( $res->CODIGO == $codSelect ){
					$combo .= '<option value="'.$res->CODIGO.'" selected="selected">'.mb_strtoupper($res->DESCRICAO).'</option>';
				}else{
					$combo .= '<option value="'.$res->CODIGO.'">'.mb_strtoupper($res->DESCRICAO).'</option>';
				}
			}
		}
	}else{
		for($i=0;$i < count($opt);$i++){
			if( $opt[$i] == $codSelect ){
				$combo .= '<option value="'.$opt[$i].'" selected="selected">'.$opt[$i].'</option>';
			}else{
				$combo .= '<option value="'.$opt[$i].'">'.$opt[$i].'</option>';
			}
		}
	}
	if($nomeId != NULL){ $combo .= '</select>'; }
	echo $combo;
}
//--->
function menuActions($codigo){
	$_links('',
			'6/prefeitura/sistema/cadContribuintes.php',
			'6/prefeitura/sistema/alteraremp.php?codigo=',
			'6/prefeitura/sistema/excluiremp.php?codigo=',
			'6/prefeitura/sistema/consultaemail.php?codcontribuinte=',
			'6/prefeitura/contribuintes/consultaSociosEmp.php?codcontribuinte=',
			'6/prefeitura/sistema/consultaContadorEmp.php?codcontribuinte=',
			'6/prefeitura/sistema/consultaAtivEmp.php?codcontribuinte=',
			'6/consultaopemp.php?codcontribuinte=',
			'6/endereco/pdf.php?codigo=',
			'#',
			'#',
			'#',
			'#');
	//if($codigo != NULL):
		$sessao = $_SESSION['codsessao'];
		$count = 1;
		$res = "<ul>";
		while($res_Permissao = ibase_fetch_assoc($codigo)):
			$reslink = $res_Permissao['HABILITADO'] == 1 ? $_links[$count] : '#';
			$res .= '<li><a href="'.$reslink.'" style="width:100px;border-radius:5px;background:#CBE7E3;" title="'.$res_Permissao['OBSERVACAO'].'">'.$res_Permissao['DESCRICAO'].'</a></li>';
			$count++;
		endwhile;
		$res .= "</ul>";
 	//endif;
	echo $res;
}