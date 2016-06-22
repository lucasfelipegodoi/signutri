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
	
	$output = array();
	$result = mysql_query("select * from ocorrencias WHERE localizacao=".$_POST['localizacao']." ORDER BY TITULO ASC");
    while($row = mysql_fetch_array($result) ){
 		array_push($output, array("id"=>$row['id'], "titulo"=> $row['titulo']));
    }
	echo json_encode( $output );
?>