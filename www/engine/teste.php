<?php

if(isset($_GET['id'])) {
	$id = $_GET['id'];
} else {
	$id = $_POST['id'];
}	

switch ($id) {
	case "teste":
		Teste();
		break;
}
//---------------------------------------------------------------------------
function Teste() {
	$login = TRUE;

	if($login) {
		echo "success";
	} else {
		echo "failed";
	}
}
//---------------------------------------------------------------------------
?>