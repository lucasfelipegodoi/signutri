<?php
	/**
	 * header.php
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
	// Proibe a abertura do arquivo diretamente.
	require_once (dirname(dirname(__FILE__)) . "/config/funcoes.php");
	protegeArquivo(basename(__FILE__));
	header ('Content-type: text/html; charset=UTF-8');
?>
<!DOCTYPE HTML>
<html lang="pt_BR">
	<head>
		<meta charset="utf-8" />
		<!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame
		Remove this if you use the .htaccess -->
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<title><?php echo SISTITLE; ?></title>
		<meta name="description" content="<?php echo SISDESC; ?>" />
		<meta name="author" content="<?php echo SISAUTHOR; ?>" />
		<meta name="viewport" content="width=device-width; initial-scale=1.0" />
		<!-- Replace favicon.ico & apple-touch-icon.png in the root of your domain and delete these references -->
		<link rel="shortcut icon" href="/favicon.ico" />
		<link rel="apple-touch-icon" href="/apple-touch-icon.png" />		
		<?php
			loadCSS('reset');
			loadCSS('style');
			loadCSS('jquery-ui');
			loadCSS('datatables', NULL, TRUE);
			loadJS('jquery-1.9.1.min');
			loadJS('jquery-ui');
			loadJS('jquery.validate.min');
			loadJS('jquery.validate.mensagens');
			loadJS('jquery.maskedinput.min');
			loadJS('jquery.dataTables.min');
			loadJS('datapicker');
			loadJS('mascaramento');						
			loadJS('geral');
			loadJS('cep');
			loadJS('nis');
			if (SISACAO == 'listar') {
				
		?>
		<script type="text/javascript" charset="utf-8">
			$(document).ready(function() {
				$('#listar').dataTable( {
					"bProcessing": true,
					"bServerSide": true,
					"sAjaxSource": "<?= AJAXPATH.SISMODULO; ?>.php",
					<?php if (SISMODULO == "logs" OR SISMODULO == "beneficiarios") echo '"aaSorting": [[ 0, "desc" ]],'; ?>					
					"oLanguage" : {
						"sProcessing" : "Processando...",
						"sLengthMenu" : "Mostrar _MENU_ registros",
						"sZeroRecords" : "Não foram encontrados resultados",
						"sInfo" : "Mostrando de _START_ até _END_ de _TOTAL_ registros",
						"sInfoEmpty" : "Mostrando de 0 até 0 de 0 registros",
						"sInfoFiltered" : "(filtrado de _MAX_ registros no total)",
						"sInfoPostFix" : "",
						"sSearch" : "Buscar:",
						"sUrl" : "",
						"oPaginate" : {
							"sFirst" : "Primeiro",
							"sPrevious" : "Anterior",
							"sNext" : "Seguinte",
							"sLast" : "Último"
						}
					}
				} );
			} );
		</script>
		<?php
			}
		?>		
		<!--[if lte IE 8]>
		<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->		
	</head>
	<body onload="atualizarDataHora()">
		<table id="main">
			<tr>
				<td id="header">
					<header>
						<div id="headerLogoSMS"></div>
						<div id="headerLogo"></div>
						<nav id="menu">				
							<?php 
								loadTemplate("menu-top");
								if (verificaSessao()) loadTemplate('menu-usuario'); 
							?>
						</nav>						 	
					</header>
				</td>
			</tr>
			<tr>
				<td id="content">
					<?php if (verificaSessao()) loadTemplate("menu-esquerdo"); ?>