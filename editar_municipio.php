<?php
	only_logged("AB");
	
	$consulta = mysql_query("SELECT * FROM municipio WHERE id = ".$_GET[cid]);
	
	if(mysql_num_rows($consulta)<0) die("Município não encontrado!");
	
	if($_GET[excluir]==1){
		mysql_query("DELETE FROM municipio WHERE id = ".$_GET[cid]);
		javascript_die('alert("Municipio excluído com sucesso!");document.location="?mode=consulta_curso";');
	}
	
	$DADOS = mysql_fetch_array($consulta);
	
	if($_POST){		
		
		foreach($_POST as $elemento => $valor){
			$valor = trim($valor);			
			if($erro==false){
				switch($elemento){ //  ((strlen($valor)<3)||(strlen($valor)>30))
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
		
		//$erro = (mysql_num_rows(mysql_query("SELECT nome FROM cursos WHERE nome = '".$FORM[nome]."'"))>0) ? "Dados redundantes!" : false;
				
		if($erro==false){
			mysql_query("UPDATE municipio SET IdMunicipio = '".$FORM[IdMunicipio_m]."',
                                                           municipio_mn = '".$FORM[municipio_mn]."',
                                                           uf_mn = '".$FORM[uf_mn]."',
                                                           area_mn = '".$FORM[area_mn]."'

                                                           populacao_mns='".$FORM[populacao_mn]."',
                                                           gentilico_mn='".$FORM[gentilico_mn]."',
														   densidade_mn='".$FORM[densidade_mn]."',
                                                           pib_mn='".$FORM[pib_mn]."',
														   data_mn='".$FORM[data_mn]."',
                                                           
                                                           WHERE id = ".$_GET[cid])


                                                or die(mysql_error());
			




            javascript_die("parent.board_msg('Municipio editado com sucesso!','show','pulsate');");
			
		}else{
			javascript_die("parent.form_error('".$erro."','show','pulsate');");
		}		
	}
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=windows-1252" />
	<link type="text/css" href="css/style2.css" rel="stylesheet" />
	<link type="text/css" href="css/ui-lightness/jquery.ui.all.css" rel="stylesheet" />
	<?require("javascript.php");?>
	<script>
		function excluir(){
			return (confirm("ATENÇÃO: Esse registro será permanentemente apagado dos registros!\nDeseja confirmar a exclusão?")) ? document.location = "?mode=editar_curso&excluir=1&cid=<?=$_GET[mid];?>" : false;
		}
		function form_error(stra,strb,strc){
			if(form_errord!=true) board_alert(stra,strb,strc);
			form_errord = true;
		}		
		function check_form(){
			
			form_errord = false;
			
   var formd = document.form_editar_municipio;
   
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
<body style="background-color: transparent" onload="mainframe_height(100);">

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
<form method="post" name="form_editar_municipio" id="form_editar_municipio" onsubmit="return check_form();" target="submitframe">
	<div class="datagrid" style="width: 75%">
		<table>
			<thead><tr>
			  <th colspan="2" align="center">Editar município</th></tr></thead>
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
			<tfoot><tr><td colspan="2" align="center"><div id="no-paging"><input type="submit" value="Gravar" /><input type="button" value="Excluir" onclick="excluir();" /></div></tr></tfoot>
		</table>
	</div>
</form>
</center>
<iframe name="submitframe" src="" style="display:none;"/>

</body>
</html>
