/*
 * datapicker.js
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
	$("#data, #gestante_dum").datepicker({
		dateFormat : 'dd/mm/yy',
		dayNames : ['Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado'],
		dayNamesMin : ['D', 'S', 'T', 'Q', 'Q', 'S', 'S', 'D'],
		dayNamesShort : ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb', 'Dom'],
		monthNames : ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'],
		monthNamesShort : ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
		nextText : 'Próximo',
		prevText : 'Anterior',
		changeMonth: true,
	    changeYear: true
	});
});

