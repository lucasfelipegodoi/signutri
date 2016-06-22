<?php
	/**
	 * menu-top.php
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
<div id="menu-top">
	<div id="menu-top-opcoes">
		<div style="margin-top: 8px;">Campos dos Goytacazes - <span id="dataextenso"></span> - <span id="horas"></span></div>
		<!--
		<ul class="menu">
		<li>
		<a <?php if(!isset($_GET['m'])) echo 'class="active"'; echo 'href="'.BASEURL.'"'; ?> >INÍCIO</a>
		</li>
		<li>
		<a <?php if(isset($_GET['m']) && $_GET['m'] == "beneficiarios") echo 'class="active"'; ?> >BENEFICIÁRIOS</a>
		<ul>
		<?php if (verificaNivel(NIVELOPER)) { ?>
		<li>
		<a href="?m=beneficiarios&a=adicionar">Adicionar</a>
		</li>
		<?php } ?>
		<li>
		<a href="?m=beneficiarios&a=listar">Listar</a>
		</li>
		<li>
		<a href="?m=beneficiarios&a=listar">Bairros</a>
		</li>
		<li>
		<a href="?m=beneficiarios&a=listar">Unidades de Saúde</a>
		</li>
		<li>
		<a href="?m=beneficiarios&a=listar">Ocorrencias</a>
		</li>
		</ul>
		</li>
		<li>
		<a <?php if(isset($_GET['m']) && $_GET['m'] == "profissionais") echo 'class="active"'; ?> >BAIRROS</a>
		<ul>
		<?php if (verificaNivel(NIVELOPER)) { ?>
		<li>
		<a href="?m=profissionais&a=adicionar">Adicionar</a>
		</li>
		<?php } ?>
		<li>
		<a href="?m=profissionais&a=listar">Listar</a>
		</li>
		</ul>
		</li>
		<?php if (verificaNivel(NIVELADMIN)) { ?>
		<li>
		<a <?php if(isset($_GET['m']) && $_GET['m'] == "usuarios") echo 'class="active"'; ?> >USUÁRIOS</a>
		<ul>
		<li>
		<a href="?m=usuarios&a=adicionar">Adicionar</a>
		</li>
		<li>
		<a href="?m=usuarios&a=listar">Listar</a>
		</li>
		</ul>
		</li>
		<li>
		<a <?php if(isset($_GET['m']) && $_GET['m'] == "logs") echo 'class="active"'; ?> href="?m=logs">REGISTROS</a>
		</li>
		<?php } ?>
		</ul>
		-->
	</div>
</div>