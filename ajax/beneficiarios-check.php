<?php
	/*
	 * ocorrencias-select.php
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
	// Carrega as configurações do sistema.
	require_once (dirname(dirname(__FILE__)) . "/config/config.php");
	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	 * Easy set variables
	 */
	 
	/* DB table to use */
	$sTable = "beneficiarios";
	 	
	/* Database connection information */
	$gaSql['user']       = DBUSER;
	$gaSql['password']   = DBPASS;
	$gaSql['db']         = DBNAME;
	$gaSql['server']     = DBHOST;
	
	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	 * If you just want to use the basic configuration for DataTables with PHP server-side, there is
	 * no need to edit below this line
	 */
	
	/* 
	 * Local functions
	 */
	function fatal_error ( $sErrorMessage = '' )
	{
		header( $_SERVER['SERVER_PROTOCOL'] .' 500 Internal Server Error' );
		die( $sErrorMessage );
	}

	
	/* 
	 * MySQL connection
	 */
	if ( ! $gaSql['link'] = mysql_pconnect( $gaSql['server'], $gaSql['user'], $gaSql['password']  ) )
	{
		fatal_error( 'Could not open connection to server' );
	}

	if ( ! mysql_select_db( $gaSql['db'], $gaSql['link'] ) )
	{
		fatal_error( 'Could not select database ' );
	}
	mysql_set_charset('UTF8', $gaSql['link']);

	$result = mysql_query("select * from ".$sTable." WHERE nis=".$_REQUEST['nis']);
	$row = mysql_fetch_array($result);
	$count = mysql_num_rows($result);
	$output = array();
	$output['count'] = $count;
	if ($count >= 1) $output['id'] = $row['id'];
	echo json_encode( $output );
	
?>