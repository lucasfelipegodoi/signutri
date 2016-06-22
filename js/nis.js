$(document).ready(function() {

	//Quando o campo cep perde o foco.
	$("#nis").blur(function() {
		//Nova variável com valor do campo "nis".
		var nis = $(this).val();

		//Verifica se campo nis possui valor informado.
		if (nis != "") {
			jQuery.ajax({
				type : 'POST',
				url : 'ajax/beneficiarios-check.php',
				data : 'nis=' + nis,
				dataType : "json",
				success : function(data) {
					if (data.count != 0) {
						if (confirm('NIS já cadastrado! Deseja editar?')) {
							window.location="http://saude.campos.rj.gov.br/signutri/?m=beneficiarios&a=editar&id=" + data.id;
						}					 
					}
				}
			});
		} //end if.
	});
});