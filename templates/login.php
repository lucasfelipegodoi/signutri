<?php
	/**
	 * login.php
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
?>
	<script type="text/javascript" charset="utf-8">
		$(document).ready(function() {
			$("#userLogin").validate({
				rules : {
					usuario : {
						required : true,
						minlength : 4
					},
					senha : {
						required : true,
						rangelength : [4, 20]
					},
				}
			});
		}); 
	</script>
	<div id="pageLogin">
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
		<form id="userLogin" action="" method="post">
			<fieldset>
				<legend>
					<?php echo $GLOBALS['text']['login_titulo']; ?>
				</legend>
				<ul>
					<li>
						<label for="usuario"><?php echo $GLOBALS['text']['login_usuario']; ?></label>
						<input type="text" name="usuario" style="width:220px;" autofocus="autofocus" value="<?php if(isset($_POST['usuario'])) echo $_POST['usuario']; ?>" onkeyup="return cUpper(this);" onblur="return cUpper(this);">
					</li>
					<li>
						<label for="senha"><?php echo $GLOBALS['text']['login_senha']; ?></label>
						<input type="password" name="senha" style="width:220px;" value="<?php if(isset($_POST['senha'])) echo $_POST['senha']; ?>">
					</li>
				</ul>
			</fieldset>
			<p class="right">
				<input type="submit" name="entrar" id="entrar" value="" title="Entrar" class="confirmar">
			</p>
		</form>
	</div>

<?php
	loadTemplate('footer');
?>