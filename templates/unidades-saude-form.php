<?php
	/*
	 * 
	 * unidades-saude-form.php
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
	loadTemplate('header');	
	if (!empty($_POST)) {
		$nome = $_POST['nome'];
		$telefone = $_POST['telefone'];
	} elseif (isset($dados)) {
		$nome = $dados->nome;
		$telefone = $dados->telefone;			
	}
	
	if (verificaNivel(NIVELADMIN)) {
		$linkCancelar = BASEURL."?m=unidades-saude&a=listar";
	}else {
		$linkCancelar = BASEURL;
	}
?>
	<script type="text/javascript" charset="utf-8">
		$(document).ready(function() {		
			$("#form").validate({
				rules : {
					nome : {
						required : true,
						minlength : 3
					},															
				}
			});
			<?php 
				switch (SISACAO) {
					case 'exibir':
			?>
						$('input[type=text]').attr('disabled', 'disabled');
						$('#exibir').hide();
			<?php
					break;
				}					
			?>				 						
		}); 
	</script>	
	<div id="page">
		<?php
			if (isset($_GET['msg'])) {
				loadConfig('mensagens', $_GET['msg']);
			}
			if (isset($GLOBALS['msg']) && isset($GLOBALS['msg_tipo'])) {
				printMSG($GLOBALS['msg'], $GLOBALS['msg_tipo']); 
				unset($GLOBALS['msg']);
				unset($GLOBALS['msg_tipo']);
			}
		?>
		<form id="form" action="" method="post">
			<fieldset>
				<legend>
					<?= $GLOBALS['text']['unidades_saude_'.SISACAO.'_titulo']; ?>
				</legend>
				<ul>
					<li>
						<label for="nome"><?= $GLOBALS['text']['unidades_saude_nome']; ?></label>
						<input type="text" name="nome" id="nome" value="<?php if(isset($nome)) echo $nome; ?>" onkeyup="return cUpper(this);" onblur="return cUpper(this);">
					</li>													
					<li>
						<label for="telefone"><?= $GLOBALS['text']['unidades_saude_telefone']; ?></label>
						<input type="text" name="telefone" id="telefone" value="<?php if(isset($telefone)) echo $telefone; ?>">
					</li>			
				</ul>
			</fieldset>
			<div class="right">
				<input type="button" name="cancelar" id="cancelar" onclick="location.href='?m=unidades-saude&a=listar'" title="Cancelar" class="cancelar">
				<input type="submit" name="<?= SISACAO; ?>" id="<?= SISACAO; ?>" class="confirmar" value="" onclick="return confirm('<?= $GLOBALS["text"]["msg_confirma_".SISACAO] ; ?>')" />
			</div>
		</form>
	</div>

<?php
	loadTemplate('footer');
?>