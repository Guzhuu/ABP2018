<?php
/* 
	Controller del Deportista
*/
	session_start();
	include_once '../Functions/Autenticacion.php';
	if(!isAdmin()){
		header('Location: ../index.php');
	}
	
	include '../Modelos/Deportista.php';
	
	include '../Views/Deportista/Deportista_EDIT.php';
	include '../Views/Deportista/Deportista_SEARCH.php';
	include '../Views/Deportista/Deportista_DELETE.php';
	include '../Views/Deportista/Deportista_SHOWCURRENT.php';
	include '../Views/Deportista/Deportista_ADD.php';
	include '../Views/Deportista/Deportista_SHOWALL.php';
	include '../Views/MESSAGE.php';
	
function get_data_form(){
	if(!isset($_REQUEST['DNI'])){
		$_REQUEST['DNI'] = '';
	}

	if(!isset($_REQUEST['Sexo'])){
		$_REQUEST['Sexo'] = '';
	}

	if(!isset($_REQUEST['rolEntrenador'])){
		$_REQUEST['rolEntrenador'] = '';
	}
	if(!isset($_REQUEST['Contrasenha'])){
		$_REQUEST['Contrasenha'] = '';
	}
	$DNI = $_REQUEST['DNI'];
	$Edad = $_REQUEST['Edad'];
	$Nombre = $_REQUEST['Nombre'];
	$Apellidos = $_REQUEST['Apellidos'];
	$Sexo = $_REQUEST['Sexo'];
	$Contrasenha = $_REQUEST['Contrasenha'];
	$Cuota_socio = $_REQUEST['Cuota_socio'];
	$rolEntrenador = $_REQUEST['rolEntrenador'];


	$deportista = new Deportista($DNI,$Edad,$Nombre,$Apellidos,$Sexo,$Contrasenha,$Cuota_socio,false,$rolEntrenador);
 
	return $deportista;
}
	

if (!isset($_REQUEST['submit'])){ //si no viene del formulario, no existe array POST
	$_REQUEST['submit'] = 'SHOWALL';
}

switch ($_REQUEST['submit']){
	case 'ADD':
		if(!$_POST){//Si GET
			$muestraADD = new Deportista_ADD();//Mostrar vista add
		}else{
			$deportista = get_data_form();//Si post cogemos deportista
			$respuesta = $deportista->ADD();//Y lo añadimos
			new Mensaje($respuesta, '../Controllers/Controller_Deportista.php');// y a ver qué ha pasado en la BD
		}
		break;
		
	case 'EDIT':
		if(!$_POST){//Si GET
			$deportista = new Deportista($_REQUEST['DNI'],'', '', '', '', '', '', '', '');//Editar deportista seleccionado
			$deportista->_getDatosGuardados();//Rellenar con los datos de la BD
			new Deportista_EDIT($deportista);//Mostrar vista
		}else{
			$deportista = get_data_form();//Coger datos
			$respuesta = $deportista->EDIT();//Actualizarlos
			new Mensaje($respuesta, '../Controllers/Controller_Deportista.php');//A ver que pasa con la BD, qué intrigante
		}
		break;
		
	case 'SEARCH':
		if(!$_POST){//Si GET
			$muestraSEARCH = new Deportista_SEARCH();//Mostrar vista buscadora
		}else{
			$deportista = get_data_form();//Creamos un deportista con los datos introducidos (que no insertarlo en la BD)
			$respuesta = $deportista->SEARCH();//Buscamos los datos que se parezcan a los introducidos
			if(!is_string($respuesta)){
				new Deportista_SHOWALL($respuesta);
			}else{//sino
				new Mensaje($respuesta, '../Controllers/Controller_Deportista.php');//Mensaje de error, que hay muchos
			}
		}
		break;
		
	case 'DELETE':
		if(!$_POST){//Si GET
			$deportista = new Deportista($_REQUEST['DNI'],'', '', '', '', '', '', '', '');//Coger deportista guardado a eliminar
			$deportista->_getDatosGuardados();//Rellenar datos
			new Deportista_DELETE($deportista);//Mostrar vissta 
		}else{//Si confirma borrado llega por post
			$deportista = new Deportista($_POST['DNI'],'', '', '', '', '', '', '', '');//Clave
			$respuesta = $deportista->DELETE();//Borrar deportista con dicha clave
			new Mensaje($respuesta, '../Controllers/Controller_Deportista.php');//A ver qué pasa en la BD
		}
	break;
		
	case 'SHOWCURRENT':
		if(!$_POST){//Si GET
			$deportista = new Deportista($_REQUEST['DNI'],'', '', '', '', '', '', '', '');//Coger clave del deportista
			$respuesta = $deportista->SHOWCURRENT();
			if(!is_string($respuesta)){//NO debería ser posible pedir un showcurrent de algo no existente pero si esp osible retornará un string, así que si no es un string es un deportista
				$deportista->_getDatosGuardados();
				new Deportista_SHOWCURRENT($deportista);//Mostrar al deportista rellenado
			}else{//sino
				new Mensaje($respuesta, '../Controllers/Controller_Deportista.php');//Mensaje de error, que hay muchos
			}
		}
		break;
		
	case 'SHOWALL':
		$deportista = new Deportista('','','','','','','','','');//No necesitamos deportista para buscar (pero sí para acceder a la BD)
		$respuesta = $deportista->SHOWALL();//Todos los datos de la BD estarán aqúi
		new Deportista_SHOWALL($respuesta);//Le pasamos todos los datos de la BD
		break;
		
	default:
		$deportista = new Deportista('','','','','','','','','');//No necesitamos deportista para buscar (pero sí para acceder a la BD)
		$respuesta = $deportista->SHOWALL();//Todos los datos de la BD estarán aqúi
		new Deportista_SHOWALL($respuesta);//Le pasamos todos los datos de la BD
		break;
}
?>