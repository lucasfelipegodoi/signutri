<?php 
	/**
	 * config.php
	 *
	 * SigNutri - Sistema de Gestão da Nutrição
	 * Projeto desenvolvido para a Secretaria de
	 * Saúde de Campos dos Goytacazes.
	 *
	 * Versão: 1.0
	 * Criado: Campos dos Goytacazes, 1 de dezembro de 2013
	 * Desenvolvido por: Marcus Ribeiro Perrout
	 * E-mail: contato@perrout.com.br
	 * 
	 */
	//Diretorio do sistema
	define('BASEPATH', dirname(dirname(__FILE__)).'/');
	define('BASEURL', ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') ? 'https://' : 'http://') . $_SERVER['HTTP_HOST'] . '/signutri/');
	define('CONFIGPATH', 'config/');
	define('CLASSESPATH', 'classes/');
	define('MODULOSPATH', 'modulos/');
	define('IMAGENSPATH', BASEURL.'imagens/');
	define('CSSPATH', 'css/');
	define('JSPATH', 'js/');
	define('AJAXPATH', BASEURL.'ajax/');	
	define('TEMPLATEPATH', 'templates/');
	define('PLUGINSPATH', 'plugins/');
	define('UPLOADPATH', 'upload/');
	define('FOTOSPATH', BASEURL.UPLOADPATH.'fotos/');
		
	//Banco de Dados
	define('DBHOST', 'localhost');
	define('DBUSER', 'saude_signutri');
	define('DBPASS', '3fW2Y2FNq4PWDJRF');
	define('DBNAME', 'saude_signutri');
	
	//Banco de Dados
	//define('DBHOST', 'localhost');
	//define('DBUSER', 'root');
	//define('DBPASS', '123mudar');
	//define('DBNAME', 'signutri');

	
	//Dados do Sistema	
	define('SISNAME', 'SigNutri - Sistema de Gestão da Nutrição da Secretaria Municipal de Saúde');
	define('SISTITLE', 'SigNutri - Sistema de Gestão da Nutrição da Secretaria Municipal de Saúde');
	define('SISDESC', 'SigNutri - Sistema de Gestão da Nutrição da Secretaria Municipal de Saúde');
	define('SISEMAIL', 'gti@sms.campos.rj.gov.br');
	define('SISCLIENTE', 'Secretaria Municipal de Saúde');
	define('SISTELEFONE', '(22) 2726-1350 / 2733-3908 / 2733-0993');
	define('SISENDERECO', 'Rua Voluntários da Pátria, 875 - Centro');
	define('SISCIDADE', 'Campos dos Goytacazes - RJ');
	define('SISCEP', '28030-260');
	define('SISKEYWORDS', 'SigNutri - Sistema de Gestão da Nutrição da Secretaria Municipal de Saúde');
	define('SISAUTHOR', 'Marcus Ribeiro Perrout - http://www.perrout.com.br/');
	define('SISSTATUS', FALSE);
	define('SESSIONNAME', 'SigNutri');
	define('NIVELADMIN', '9');
	define('NIVELOPER', '3');
	define('NIVELUSER', '1');
	$modulo = (isset($_GET['m'])) ? strtolower($_GET['m']) : 'principal' ;
	$acao = (isset($_GET['a'])) ? strtolower($_GET['a']) : NULL ;
	define('SISMODULO', $modulo);
	define('SISACAO', $acao);	
	
	//Textos do Sistema
	$GLOBALS['text'] = parse_ini_file('pt-br.ini');	

	// Proibe a abertura do arquivo diretamente.
	if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { header("Location: " . BASEURL . "?msg=4"); }	
?>