<?php
/*
	Comprbar si existe cookie de login aka DNI
*/
function autenticado(){
	if(isset($_SESSION['DNI'])){//Si existe, existe
		return true;
	}else{//Si no existe, no existe
		return false;
	}
}

function isAdmin(){
	if(isset($_SESSION['rolAdmin']) && $_SESSION['rolAdmin']){
		return true;
	}else{
		return false;
	}
}

function isEntrenador(){
	if(isset($_SESSION['rolEntrenador']) && $_SESSION['rolEntrenador']){
		return true;
	}else{
		return false;
	}
}
?>
