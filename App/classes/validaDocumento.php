<?php
header('Content-Type: text-html; charset=UTF-8');
//função para validar cpf
if(isset($_GET('cpf'))){ verCPF($_GET('cpf')); }
function verCPF($cpf){
	//$cpf = $cpf;
	//Deixar apenas os números
	$cpf = preg_replace('/[^0-9]/', '', $cpf);
	$dgtA = 0;
	$dgtB = 0;
	//Calcular e Validar o digito 1
	for($i=0,$x=10; $i<=8; $i++, $x--):
		$dgtA += $cpf[$i]*$x;
	endfor;
	//Calcular e Validar o digito 2
	for($i=0,$x=11; $i<=9; $i++, $x--):
		if(str_repeat($i, 11) == $cpf){ echo 'CPF invalido'; return FALSE; }
		$dgtB += $cpf[$i]*$x;
	endfor;
	$dgtA = (($dgtA%11) < 2) ? 0 : ($dgtA%11)-11;
	$dgtB = (($dgtB%11) < 2) ? 0 : ($dgtB%11)-11;
	if($dgtA != $cpf[9] || $dgtB != $cpf[10]):
		echo 'CPF inválido';
		//return FALSE;
	else:
		echo 'CPF válido';
		//return TRUE;
	endif;
}