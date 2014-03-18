<?php
	only_logged("AB");
	
	if($_POST){
		
		foreach($_POST as $elemento => $valor){
			$valor = trim($valor);			
			if($erro==false){
				switch($elemento){
					case "IdMunicipio_mn": $erro = ((strlen($valor)=10)) ? "Código do Munucipio" : false; $FORM[$elemento] = $valor;break;
					case "municipio_mn": $erro = ((stllen($valor))||(strlen($valor)<50)) ? "matricula_us" : false; $FORM[$elemento] = $valor;break;
					case "uf_mn": $erro = ((!is_numeric($valor))||(strlen($valor)<11)||(strlen($valor)>14)) ? "uf_mn" : false; $FORM[$elemento] = $valor;break;
					case "area_mn": $erro = ((strlen($valor)>3)||(strlen($valor)<10)) ? "area_mn" : false; $FORM[$elemento] = $valor;break;
                    case "populacao_mn": $erro = ((strlen($valor)<=3)||(strlen($valor)>=10)) ? "populacao_mn" : false; $FORM[$elemento] = $valor;break;
					case "gentilico_mn": $erro = ((strlen($valor)<50)) ? "gentilico_mn" : false; $FORM[$elemento] = $valor;break;
					case "densidade_mn": $erro = ((strlen($valor)<9)) ? "densidade_mn" : false; $FORM[$elemento] = $valor;break;
					case "pib_mn": $erro = ((strlen($valor)<10)) ? "pib_mn" : false; $FORM[$elemento] = $valor;break;
					case "data_mn": $erro = (($valor!="")&&(!valida_data($valor))) ? "data_mn" : false; $FORM[$elemento] = data_br_us($valor);break

				}
			}
		}
		
		
		if($erro==false){
			mysql_query("INSERT INTO usuario VALUES (NULL,
                                                           '".$FORM[IdMunicipio_mn]."',
														   '".$FORM[municipio_mn]."',
                                                           '".$FORM[uf_mn]."',
														   '".$FORM[area_mn]."',
                                                           '".$FORM[populacao_mn]."',
														   '".$FORM[gentilico_mn]."',
                                                           '".$FORM[densidade_mn]."',
														   '".$FORM[pib_mn]."',
                                                           '".$FORM[data_mn]."',)")
														or die(mysql_error());
														
			javascript_die("parent.board_msg('Usuário cadastradado com sucesso!','show','pulsate');
                            parent.document.form_cadastro_usuario.reset();");
				
		}else{
			javascript_die("parent.form_error('".$erro."','show','pulsate');");
		}	
			
		$adicionado = true;
	}
	
	foreach($_CONFIG[niveis_acesso] AS $chave => $valor) $niveis_acesso .= ($chave!="A") ? ('<option value="'.$chave.'">'.$valor.'</option>') : "";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=windows-1252" />
	<link type="text/css" href="css/style2.css" rel="stylesheet" />
	<link type="text/css" href="css/ui-lightness/jquery.ui.all.css" rel="stylesheet" />
	<?require("javascript.php");?>
	<script>
		<?=($adicionado==true) ? "board_msg('Patrimônio adicionado com sucesso!','show','bounce');" : "";?>
		function limpar_form(){
			return (confirm("Tem certeza que deseja limpar o formulário?")) ? document.form_adicionar.reset() : false;
		}
		function form_error(stra,strb,strc){
			if(form_errord!=true) board_alert(stra,strb,strc);
			form_errord = true;
		}
		function formatTelefone(element, e){
			if (e.keyCode != 8){
				length = element.value.length;
				if (length == 2){
				  if(element.value.charAt(0)!="(") element.value = "(" + element.value + ")";
				}
				if (length == 3) if (element.value.charAt(0)=="(") element.value += ")";
				if (length == 8) element.value += "-";
			}
		}
		function check_form(){	
			
			form_errord = false;
			
			var formd = document.form_cadastro_municipio;
			
			if(formd.IdMunicipio_mn.value.length< 10 ){
				form_error('O campo códigpo do município deve conter no mínimo 10 caracteres!','show','bounce');

            }else if((isNaN(formd.municipio_mn.value.length<50)){
				form_error('O campo Matrícula deve 9 caracteres!','show','bounce');

            }else if((formd.uf_mn.value.length>3)||(formd.uf_mn.value.length<= 50 )){
				form_error('O campo de Municipio deve conter entre 3 e 50 caracteres!','show','bounce');
				
			}else if(formd.populacao_mn.value.length<= 10 ){
				form_error('O campo Polução deve conter no máximo 10 caracteres!','show','bounce');

            }else if((formd.gentilico_mn.value.length>3)||(formd.gentilico_mn.value.length<=50 )){
				form_error('O campo de gentilico deve conter entre 3 e 50 caracteres!','show','bounce');

            }else if((isNaN(formd.densidade_mn.value.length <=10)){
				form_error('O campo densidade deve conter até 10 caracteres!','show','bounce');

            }else if((isNaN(formd.pib_mn.value.length <=10)){
				form_error('O campo pibe deve conter até 10 caracteres!','show','bounce');


            }else if(formd.anoSenso_mn.value.length<10){
				form_error('Ano do senso Inválido!','show','bounce');

            }
			
			return (form_errord==true) ? false : true;
		}
	</script>
</head>
<body style="background-color: transparent" onload="mainframe_height()">

<center>
<div style="width:500px;">
	<div class="ui-widget" id="error-box" style="display:none">
		<div class="ui-state-error ui-corner-all" style="padding: 0 .7em;">
			<p><span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>
			<strong>Alert:</strong> <span id="board_alert_txt">Dados redundantes!</span></p>
		</div>
	</div>
	
	<div class="ui-widget" id="msg-box" style="display:none;">
		<div class="ui-state-highlight ui-corner-all" style="margin-top: 20px; padding: 0 .7em;">
			<p><span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;"></span>
			<strong>Mensagem!</strong> <span id="board_msg_txt">xxxxxxxxxxxxx!.</span></p>
		</div>
	</div>
</div>
<form method="post" name="form_cadastro_municipio" id="form_cadastro_municipio" onsubmit="return check_form();" target="submitframe">
	<div class="datagrid" style="width: 75%">
		<table>
			<thead><tr><th colspan="2" align="center">Cadastro de Municipios</th></tr></thead>
			<tbody>
				<tr>
					<td align="right">Cód. Município: <input type="integer" maxlength="10" name="idMunicicio_mn" class="text1"/></td>
					<td align="right">Município: <input type="varchar" maxlength="50" name="municipio_mn" class="text1" /></td>
				</tr>
				<tr class="alt">
					<td align="right">UF: <input type="varchar" maxlength="50" name="uf_mn" class="text1" /></td>
					<td align="right">Área do município: <input type="float" maxlength="10" name="area_mn" class="text1" /></td>
				</tr>

                <tr class="alt">
					<td align="right">População: <input type="integer" maxlength="10" name="populacao_mn" class="text1" /></td>
					<td align="right">Gentilico: <input type="varchar" maxlength="50" name="gentilico_mn" class="text1" /></td>
				</tr>

                <tr class="alt">
					<td align="right">Densidade: <input type="float" maxlength="10" name="densidade_mn" class="text1" /></td>
					<td align="right">Pib: <input type="float" maxlength="10" name="pib_mn" class="text1" /></td>>
				</tr>

                <tr>
                    <td align="right">Ano do senso: <input type="text" maxlength="10" name="data_us" id="data_us" class="text1" onkeyup="formatar_data(this.id);" /></td>
     			</tr>

    			</tbody>
			<tfoot><tr><td colspan="2" align="center"><div id="no-paging"><input type="image" value="Cadastrar" src="imagens/btcadastrar.png" /></div></tr></tfoot>
		</table>
	</div>
</form>
</center>
<iframe name="submitframe" src="" style="display:none;"/>

</body>
</html>
