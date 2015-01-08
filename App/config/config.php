<?Php
/* Definicao do Charset */
define("CHARSET", "UTF-8");

/* Raiz do sistema */
define("BASEPATH", dirname(__FILE__).'/');

/* BASE URL do sistema */
define("BASEURL", 'http://'.$_SERVER['SERVER_NAME'].'/');
// define("BASEURL", 'http://192.168.0.102/janelaunica/') OK Local;

/* Paths do Sistema */
define("PAINELPATH", "paineladm/");
define("SISTEMAPATH", "sistema/");
define("CLASSESPATH", "classes/");
define("MODULOSPATH", "modulos/");
define("CSSPATH", "estilo/");
define("JSPATH", "js/");
define("IMAGENSPATH", "imagens/");

/* Definições Bando de Dados */
// define("DBHOST", $_SERVER['SERVER_NAME'].":/home/bancos/projeto/admjanelaunica.fdb");
// define("DBHOST", "192.168.0.102:/home/bancos/projeto/admjanelaunica.fdb");
define("DBHOST", "192.168.0.102:/home/bancos/projeto/admjanelaunica.fdb");
define("DBUSER", "JANELAMAIATI");
define("DBPASS", "123");

/* Array com Estados Brasileiros */
define("UFS",'[{
	"ID": "1",
	"Sigla": "AC",
	"Nome": "Acre"
},
     {
	"ID": "2",
	"Sigla": "AL",
	"Nome": "Alagoas"
},
     {
	"ID": "3",
	"Sigla": "AM",
	"Nome": "Amazonas"
},
     {
	"ID": "4",
	"Sigla": "AP",
	"Nome": "Amapá"
},
     {
	"ID": "5",
	"Sigla": "BA",
	"Nome": "Bahia"
},
     {
	"ID": "6",
	"Sigla": "CE",
	"Nome": "Ceará"
},
     {
	"ID": "7",
	"Sigla": "DF",
	"Nome": "Distrito Federal"
},
     {
	"ID": "8",
	"Sigla": "ES",
	"Nome": "Espírito Santo"
},
     {
	"ID": "9",
	"Sigla": "GO",
	"Nome": "Goiás"
},
     {
	"ID": "10",
	"Sigla": "MA",
	"Nome": "Maranhão"
},
     {
	"ID": "11",
	"Sigla": "MG",
	"Nome": "Minas Gerais"
},
     {
	"ID": "12",
	"Sigla": "MS",
	"Nome": "Mato Grosso do Sul"
},
     {
	"ID": "13",
	"Sigla": "MT",
	"Nome": "Mato Grosso"
},
     {
	"ID": "14",
	"Sigla": "PA",
	"Nome": "Pará"
},
     {
	"ID": "15",
	"Sigla": "PB",
	"Nome": "Paraíba"
},
     {
	"ID": "16",
	"Sigla": "PE",
	"Nome": "Pernambuco"
},
     {
	"ID": "17",
	"Sigla": "PI",
	"Nome": "Piauí"
},
     {
	"ID": "18",
	"Sigla": "PR",
	"Nome": "Paraná"
},
     {
	"ID": "19",
	"Sigla": "RJ",
	"Nome": "Rio de Janeiro"
},
     {
	"ID": "20",
	"Sigla": "RN",
	"Nome": "Rio Grande do Norte"
},
     {
	"ID": "21",
	"Sigla": "RO",
	"Nome": "Rondônia"
},
     {
	"ID": "22",
	"Sigla": "RR",
	"Nome": "Roraima"
},
     {
	"ID": "23",
	"Sigla": "RS",
	"Nome": "Rio Grande do Sul"
},
     {
	"ID": "24",
	"Sigla": "SC",
	"Nome": "Santa Catarina"
},
     {
	"ID": "25",
	"Sigla": "SE",
	"Nome": "Sergipe"
},
     {
	"ID": "26",
	"Sigla": "SP",
	"Nome": "São Paulo"
},
     {
	"ID": "27",
	"Sigla": "TO",
	"Nome": "Tocantins"
}]');