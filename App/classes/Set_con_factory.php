<?php
/*
**	Class para Setar a conexão
**	Escolher entre os bancos ADM e Prefeitura
**	Autho: Hilder / 26/11/2013
*/
class Set_Con_Factory
{
    // Método Factory parametrizado / tcpon: 0 ou null ADM; 1 ou codPrefeitura - Prefeitura
    public static function setfactory($tcon)
    {
		$tcon = isset($tcon)? $tcon: '';
		
        if (include_once "$type.php") {
            $classname = 'Driver_' . $type;
            return new $classname;
        } else {
            throw new Exception ('Driver não encontrado');
        }
    }
}
?>