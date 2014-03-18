<?php
	only_logged("AB");
	
	if($_POST){
		
		foreach($_POST as $elemento => $valor){
			$valor = trim($valor);			
			if($erro==false){
				switch($elemento){
					case "IdUsuario_us": $erro = ((strlen($valor)=10)) ? "Código do Susuário" : false; $FORM[$elemento] = $valor;break;
					case "matricula_us": $erro = ((!is_numeric($valor))||(strlen($valor)=9)) ? "matricula_us" : false; $FORM[$elemento] = $valor;break;
					case "cpf_us": $erro = ((!is_numeric($valor))||(strlen($valor)<11)||(strlen($valor)>14)) ? "cpf_us" : false; $FORM[$elemento] = $valor;break;
					case "nome_us": $erro = ((strlen($valor)<3)||(strlen($valor)>50)) ? "nome_us" : false; $FORM[$elemento] = $valor;break;
					case "data_us": $erro = (($valor!="")&&(!valida_data($valor))) ? "data_us" : false; $FORM[$elemento] = data_br_us($valor);break;
					case "instituicao_us": $erro = ((strlen($valor)<1)||(strlen($valor)>200)) ? "instituicao_us" : false; $FORM[$elemento] = $valor;break;
					case "usuario_us": $erro = ((strlen($valor)<8)) ? "usuario_us" : false; $FORM[$elemento] = $valor;break;
					case "senha_us": $erro = ((strlen($valor)<8)||(strlen($valor)>16)) ? "senha" : false; $FORM[$elemento] = md5($valor);break;
					case "senha_cfrm": $erro = (md5($valor)!=$FORM[senha]) ? "senha_cfrm" : false; $FORM[$elemento] = md5($valor);break;
					case "nivelAcesso_us": $erro = ($valor=="") ? "nivelAcesso_us" : false; $FORM[$elemento] = $valor;break;
					case "email_us": $erro = ((strlen($valor)<10)||(strlen($valor)>50)) ? "email_us" : false; $FORM[$elemento] = $valor;break;
                    case "vinculo_us": $erro = ((strlen($valor)<5)||(strlen($valor)>50)) ? "vinculo_us" : false; $FORM[$elemento] = $valor;break;

				}
			}
		}
		
		
		if($erro==false){
			mysql_query("INSERT INTO usuarios VALUES (NULL,
                                                           '".$FORM[IdUsuario_us]."',
														   '".$FORM[matricula_us]."',
                                                           '".$FORM[cpf_us]."',
														   '".$FORM[nome_us]."',
                                                           '".$FORM[data_us]."',
														   '".$FORM[instituicao_us]."',
                                                           '".$FORM[usuario_us]."',
														   '".$FORM[senha_us]."',
                                                           '".$FORM[nivelAcesso_us]."',
														   '".$FORM[email_us]."',
                                                           '".$FORM[vinculo_us]."',)")
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
			
			var formd = document.form_cadastro_usuario;
			if(formd.nome_us.value.length<3){
				form_error('O campo Nome deve conter no mínimo 3 caracteres!','show','bounce');

            }else if((isNaN(formd.matricula_us.value.length<9)){
				form_error('O campo Matrícula deve 9 caracteres!','show','bounce');

            }else if((formd.cpf_us.value.length<11)||(formd.cpf_us.value.length>14)){
				form_error('O campo CPF deve conter 11 numeros ou 14 caracteres!','show','bounce');;
				
			}else if(formd.nome_us.value.length<10){
				form_error('O campo Nome de usuário deve conter no minimo 10 caracteres!','show','bounce');

            }else if(formd.data_us.value.length<10){
				form_error('Data de registro Inválida!','show','bounce');

            }else if(formd.instituicao_us.value.length<3)||(formd.cpf_us.value.length>200)){
				form_error('O campo Instituição deve conter no minimo 3 e no máximo 200 caracteres!','show','bounce');

            }else if(formd.usuario_us.value.length<8){
				form_error('O campo Usuário deve conter no minimo 8 caracteres!','show','bounce');

            }else if((formd.senha_us.value.length<8)||(formd.senha_us.value.length>8)){
				form_error('O campo Senha deve conter 8 caracteres!','show','bounce');

            }else if(formd.senha_cfrm.value!=formd.senha.value){
				form_error('As senhas não conferem!','show','bounce');

            }else if(formd.nivelacesso_us.value==""){
				form_error('Nível de acesso indefinido!','show','bounce');

            }else if((formd.email_us.value.length<5)||(formd.email_us.value.indexOf("@")<0)){
				form_error('E-Mail inválido!','show','bounce');

            }else if(formd.vinculo_us.value.length<5){
				form_error('O tipo de vinculo deve conter no minimo 6 caracteres!','show','bounce');

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
<form method="post" name="form_cadastro_usuario" id="form_cadastro_usuario" onsubmit="return check_form();" target="submitframe">
	<div class="datagrid" style="width: 75%">
		<table>
			<thead><tr><th colspan="2" align="center">Cadastro de Usuários</th></tr></thead>
			<tbody>
				<tr>
					<td align="right">Cód. Usuário: <input type="text" maxlength="10" name="idUsuario_us" class="text1"/></td>
					<td align="right">Matrícula: <input type="text" maxlength="9" name="matricula_us" class="text1" /></td>
				</tr>
				<tr class="alt">
					<td align="right">CPF: <input type="text" maxlength="14" name="cpf_us" class="text1" /></td>
					<td align="right">Nome de usuário: <input type="text" maxlength="50" name="nome_us" class="text1" /></td>
				</tr>
				<tr>
                    <td align="right">Data de registro: <input type="text" maxlength="10" name="data_us" id="data_us" class="text1" onkeyup="formatar_data(this.id);" /></td>
					<td align="right">Instituição: <input type="text" maxlength="200" name="instituicao_us" class="text1" /></td>
				</tr>
				<tr class="alt">
					<td align="right">Usuário do sistema: <input type="text" maxlength="8" name="usuario_us" class="text1" /></td>
                    <td align="right">Senha: <input type="password" maxlength="8" name="senha_us" class="text1" /></td>
				</tr>
				<tr>
					<td align="right">Nível de acesso: <select name="nivel_acesso"><option value="">------------------------</option><?=$niveis_acesso;?></select></td>
					<td align="right">Confirmar Senha: <input type="password" maxlength="16" name="senha_cfrm" class="text1" /></td>
				</tr>
				<tr class="alt">
					<td align="right">E-Mail: <input type="text" maxlength="40" name="email_us" class="text1" /></td>
					<td align="right">Vinculo: <input type="text" maxlength="50" name="vinculo_us" class="text1" /></td>
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
