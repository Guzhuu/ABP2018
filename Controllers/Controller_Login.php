<?php
/*
	Controlador para logear un deportista
*/
session_start();
include_once '../Functions/Autenticacion.php';
if(autenticado()){//Si está autenticado, no pinta nada aquí
	header('Location: ../index.php');
}

if(!isset($_REQUEST['DNI']) && (!isset($_REQUEST['contrasenha']))){//Si no se ha llegado mediante el formulario de vistaLogin
	$_SESSION['rolAdmin'] = false;
	include '../Views/Deportista/Deportista_LOGIN.php';//Incluir vistaLogin
	new Deportista_LOGIN();//Mostrar vistaLogin
}else{//Sino
	include '../Modelos/Deportista.php';

	$deportista = new Deportista($_REQUEST['DNI'],'','','','',$_REQUEST['contrasenha'],'','','','');//Se crea un DNI con solamente el DNI y pass
	$respuesta = $deportista->LOGIN();//Se comprueba que exista en la BD

	if($respuesta == 'true'){//Si se ha encontrado ese DNI con esa contraseña
		session_destroy();
		session_start();
		$_SESSION['DNI'] = $_REQUEST['DNI'];//Inicializar session login a lo enviado
		if($deportista->ADMIN()){
			$_SESSION['rolAdmin'] = true;
		}else{
			$_SESSION['rolAdmin'] = false;
		}
		header('Location: ../index.php');//Ahora que se ha logeado se vuelve al index
	}else{//Sino
		include '../Views/MESSAGE.php';
		new Mensaje($respuesta, './Controller_Login.php');//Mednsaje que ha dado la consulta en la BD
	}
}
?>