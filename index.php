
session_start();


require("conn/MySQL_connect.php");

require("php_funcoes.php");

require("php_config.php");



$index_mode = $_GET['mode'];

$index_id = $_GET['id'];

$index_go = $_GET['go'];


$index_mode_file = "includes/".
$index_mode.".php";



	if(file_exists($index_mode_file)){
	

		include($index_mode_file);	
}

	elseif($index_mode==""){ 
		redirect($_CONFIG[main_include]);
}
	else{
	redirect("?mode=erro&erro=Página não encontrada!");
}



mysql_close($MySQL_Conn);

?>
