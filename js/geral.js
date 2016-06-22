/*
* geral.js
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
//Bordas CSS
$(document).ready(function() {
	$("input").addClass('radius5');
	$("textarea").addClass('radius5');
	$("fieldset").addClass('radius5');
	$("legend").addClass('radius5');
	$("select").addClass('radius5');
});

//Default texto nos inputs pelo title
$(document).ready(function() {
	$(".defaultText").focus(function(srcc) {
		if ($(this).val() == $(this)[0].title) {
			$(this).removeClass("defaultTextActive");
			$(this).val("");
		}
	});

	$(".defaultText").blur(function() {
		if ($(this).val() == "") {
			$(this).addClass("defaultTextActive");
			$(this).val($(this)[0].title);
		}
	});

	$(".defaultText").blur();
});

//UPPERCASE
function cUpper(cObj) {
	cObj.value = cObj.value.toUpperCase();
}

//DATA E HORA
function mostrarDataHora(mostrahora, dataextenso, horas, minutos, segundos, dia, mes, ano, Dia, Mes) {
	document.getElementById("horas").innerHTML = mostrahora;
	document.getElementById("dataextenso").innerHTML = dataextenso;
}

function atualizarDataHora() {
	var currentTime = new Date();
	var horas = currentTime.getHours();
	var minutos = currentTime.getMinutes();
	var segundos = currentTime.getSeconds();
	var dia = currentTime.getDate();
	var mes = currentTime.getMonth();
	var ano = currentTime.getFullYear();
	var Dia = currentTime.getDay();
	var Mes = currentTime.getUTCMonth();
	arrayDia = new Array();
	arrayDia[0] = "Domingo";
	arrayDia[1] = "Segunda-Feira";
	arrayDia[2] = "Terça-Feira";
	arrayDia[3] = "Quarta-Feira";
	arrayDia[4] = "Quinta-Feira";
	arrayDia[5] = "Sexta-Feira";
	arrayDia[6] = "Sabado";
	var arrayMes = new Array();
	arrayMes[0] = "Janeiro";
	arrayMes[1] = "Fevereiro";
	arrayMes[2] = "Março";
	arrayMes[3] = "Abril";
	arrayMes[4] = "Maio";
	arrayMes[5] = "Junho";
	arrayMes[6] = "Julho";
	arrayMes[7] = "Agosto";
	arrayMes[8] = "Setembro";
	arrayMes[9] = "Outubro";
	arrayMes[10] = "Novembro";
	arrayMes[11] = "Dezembro";
	if (minutos < 10)
		minutos = "0" + minutos;
	if (segundos < 10)
		segundos = "0" + segundos;
	if (dia < 10)
		dia = "0" + dia;
	if (mes < 10)
		mes = "0" + mes;
	mostrahora = horas + ":" + minutos + ":" + segundos;
	var dataextenso = arrayDia[Dia] + ", " + dia + " de " + arrayMes[Mes] + " de " + ano;
	mostrarDataHora(mostrahora, dataextenso, horas, minutos, segundos, dia, mes, ano, Dia, Mes);
	setTimeout("atualizarDataHora()", 1000);
}