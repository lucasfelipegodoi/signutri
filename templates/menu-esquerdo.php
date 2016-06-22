<?php
	/*
	 * 
	 * menu-esquerdo.php
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
?>
<script type="text/javascript" charset="utf-8">
	$(document).ready(function() {
		$( "#menu-esquerdo-opcoes" ).menu();
		<?php if (!verificaNivel(NIVELADMIN)) { ?>
			$("#usuarios").addClass('ui-state-disabled');
			$("#logs").addClass('ui-state-disabled');	
		<?php } ?> 		
		<?php if (!verificaNivel(NIVELOPER)) { ?>
			$("#beneficiarios-add").addClass('ui-state-disabled');
			$("#config").addClass('ui-state-disabled');
		<?php } ?> 		
	});	 
</script>
<div id="menu-esquerdo">
	<div class="ui-widget-header ui-corner-all" style="width: 144px; height: 20px; margin-left: 5px; padding-bottom: -3px">
		<div style="padding-top: 3px;">MENU</div>	
	</div>	
	<ul id="menu-esquerdo-opcoes"  style="margin-top: -5px">
		<li><a href="<?= BASEURL; ?>">INÍCIO</a></li>
	  	<li id="beneficiarios">
	  		<a href="#">BENEFICIÁRIOS</a>
	    	<ul>
	      		<li id="beneficiarios-add"><a href="?m=beneficiarios&a=adicionar">ADICIONAR</a></li>
	      		<li id="beneficiarios-list"><a href="?m=beneficiarios&a=listar">LISTAR</a></li>
	    	</ul>	  	
	  	</li>
	  	<li id="config">
	    	<a href="#">CONFIGURAÇÕES</a>
	    	<ul>
		      	<li id="config-unidades">
		      		<a href="#">UNIDADE DE SAÚDE</a>
			    	<ul>
			     		<li id="config-unidades-add"><a href="?m=unidades-saude&a=adicionar">ADICIONAR</a></li>
			      		<li id="config-unidades-list"><a href="?m=unidades-saude&a=listar">LISTAR</a></li>
			    	</ul>	      	
		      	</li>
		      	<li id="config-ocorrencias">
		      		<a href="#">OCORRÊNCIA</a>
			    	<ul>
			      		<li id="config-ocorrencias-add"><a href="?m=ocorrencias&a=adicionar">ADICIONAR</a></li>
			      		<li id="config-ocorrencias-list"><a href="?m=ocorrencias&a=listar">LISTAR</a></li>
			    	</ul>	      	
		      	</li> 
		      	<li id="config-notificacoes">
		      		<a href="#">MEIO DE NOTIFICAÇÃO</a>
			    	<ul>
			      		<li id="config-notificacoes-add"><a href="?m=meio-notificacao&a=adicionar">ADICIONAR</a></li>
			      		<li id="config-notificacoes-list"><a href="?m=meio-notificacao&a=listar">LISTAR</a></li>
			    	</ul>	      	
		      	</li>  		      	    	      
	    	</ul>
	    </li>
	  	<li id="usuarios">
	    	<a href="#">USUÁRIOS</a>
	    	<ul>
	      		<li><a href="<?= BASEURL; ?>?m=usuarios&a=adicionar" title="<?= $GLOBALS['text']['usuarios_adicionar_titulo']; ?>">ADICIONAR</a></li>
	      		<li><a href="<?= BASEURL; ?>?m=usuarios&a=listar" title="<?= $GLOBALS['text']['usuarios_listar_titulo']; ?>">LISTAR</a></li>
	    	</ul>
	  	</li>	  
	  	<li id="logs"><a href="?m=logs&a=listar">REGISTROS</a></li>
	  	<li id="sair"><a href="?m=sair">SAIR</a></li>
	</ul>
</div>