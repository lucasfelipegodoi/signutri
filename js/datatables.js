/*
 * datatables.js
 *
 * SigNutri - Sistema de Gestão da Nutrição
 * Projeto desenvolvido para a Secretaria de
 * Saúde de Campos dos Goytacazes.
 *
 * Versão: 1.0
 * Criado: Campos dos Goytacazes, 1 de dezembro de 2013
 * Desenvolvido por: Marcus Ribeiro Perrout
 * E-mail: contato@perrout.com.br
 */

$(document).ready(function() {
	$('#listar').dataTable({
		"bProcessing" : true,
		"bServerSide" : true,
		"sAjaxSource" : "ajax/<?php echo $_GET['m']; ?>.php",
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
	});
});

