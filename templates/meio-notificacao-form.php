<?php
	/*
	 * 
	 * meio-notificacao-form.php
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
		$titulo = $_POST['titulo'];
	} elseif (isset($dados)) {
		$titulo = $dados->titulo;			
	}
	
	if (verificaNivel(NIVELADMIN)) {
		$linkCancelar = BASEURL."?m=meio-notificacao&a=listar";
	}else {
		$linkCancelar = BASEURL;
	}
?>
	<script type="text/javascript" charset="utf-8">
		$(document).ready(function() {	
			$("#form").validate({
				rules : {
					titulo : {
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
					<?= $GLOBALS['text']['meio_notificacao_'.SISACAO.'_titulo']; ?>
				</legend>
				<ul>
					<li>
						<label for="titulo"><?= $GLOBALS['text']['meio_notificacao_titulo']; ?></label>
						<input type="text" name="titulo" id="titulo" value="<?php if(isset($titulo)) echo $titulo; ?>" onkeyup="return cUpper(this);" onblur="return cUpper(this);">
					</li>															
				</ul>
			</fieldset>
			<div class="right">
				<input type="button" name="cancelar" id="cancelar" onclick="location.href='<?= $linkCancelar; ?>'" title="Cancelar" class="cancelar">
				<input type="submit" name="<?= SISACAO; ?>" id="<?= SISACAO; ?>" class="confirmar" value="" onclick="return confirm('<?= $GLOBALS["text"]["msg_confirma_".SISACAO] ; ?>')" />
			</div>
		</form>
	</div>

<?php
	loadTemplate('footer');
?>