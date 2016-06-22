<?php
	/**
	 * menu-usuario.php
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
	$user = new sessao();
	$id = $user -> getVar('userid');
	$usuario = ucfirst(strtolower(strtok($user -> getVar('usernome'), " ")));	 
?>
  <script type="text/javascript" charset="utf-8">
  $(function() {
    $( "#usuario-menu" )
      .button({
          text: false,
          icons: {
            primary: "ui-icon-triangle-1-s"
          }
        })
        .click(function() {
          var menu = $( this ).parent().next().show().position({
            my: "right top",
            at: "right bottom",
            of: this
          });
          $( document ).one( "click", function() {
            menu.hide();
          });
          return false;
        })
        .parent()
          .buttonset()
          .next()
            .hide()
            .menu();
  });
  </script>
<div id="menu-top-usuario">
	<div id="menu-usuario">
	  <div>
	    <button id="usuario" onclick="location.href='<?php echo BASEURL; ?>?m=usuarios&a=editar&id=<?php echo $id; ?>'"><?php echo $usuario; ?></button>
	    <button id="usuario-menu">Selecione uma ação</button>
	  </div>
	  <ul style="display: none">
	  	<li><a href="<?php echo BASEURL; ?>?m=usuarios&a=editar&id=<?php echo $id; ?>">Editar Usuário</a></li>
	    <li><a href="<?php echo BASEURL; ?>?m=usuarios&a=senha&id=<?php echo $id; ?>">Alterar Senha</a></li>
	    <li><a href="<?php echo BASEURL; ?>?m=sair">Sair</a></li>
	  </ul>
	</div>
</div>