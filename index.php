<?php
	session_start();
	include_once './Functions/Autenticacion.php';
	if(!autenticado()){
		header('Location: ./Controllers/Controller_Login.php');
	}else{
		header('Location: ./Controllers/Controller_Reserva.php');
	}

?>