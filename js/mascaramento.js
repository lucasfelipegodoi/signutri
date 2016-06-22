/*
 * mascaramento.js
 * 
 * SigSMS - Sistema de Gestão da Secretaria Municipal de Saúde
 * Projeto desenvolvido para a Secretaria de Saúde
 * de Campos dos Goytacazes.
 *
 * Versão: 1.0
 * Iniciado em:  30 de Setembro de 2013
 * Atualizado em: 
 * Desenvolvido por: Marcus Ribeiro Perrout
 * E-mail: contato@perrout.com.br
 * 
 */

//Mascaramento
$(document).ready(function() {
	$("#data, #gestante_dum").mask("99/99/9999");
	$("#telefone").mask("(99) 9999-9999");
	$("#celular").mask("(99) 99999-9999");
	$("#cep").mask("99999-999");
	$("#cpf").mask("999.999.999-99");
	$("#nis").mask("99999999999");
});