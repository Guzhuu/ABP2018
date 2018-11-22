<?php
/* 
	Controller del Horario
*/
	session_start();
	include_once '../Functions/Autenticacion.php';
	if(!isAdmin()){
		header('Location: ../index.php');
	}
	
	include '../Modelos/Horario.php';
	
	include '../Views/Horario/Horario_EDIT.php';
	include '../Views/Horario/Horario_SEARCH.php';
	include '../Views/Horario/Horario_DELETE.php';
	include '../Views/Horario/Horario_SHOWCURRENT.php';
	include '../Views/Horario/Horario_ADD.php';
	include '../Views/Horario/Horario_SHOWALL.php';
	include '../Views/MESSAGE.php';
	
function get_data_form(){
	if(!isset($_REQUEST['Horario'])){
		$_REQUEST['Horario'] = 0;
	}
	$Horario = $_REQUEST['Horario'];
	$HoraInicio = $_REQUEST['HoraInicio'];
	$HoraFin = $_REQUEST['HoraFin'];

	$horario = new Horario($Horario, $HoraInicio, $HoraFin);
 
	return $horario;
}
	

if (!isset($_REQUEST['submit'])){ //si no viene del formulario, no existe array POST
	$_REQUEST['submit'] = 'SHOWALL';
}

switch ($_REQUEST['submit']){
	case 'ADD':
		if(!$_POST){//Si GET
			$muestraADD = new Horario_ADD();//Mostrar vista add
		}else{
			$horario = get_data_form();//Si post cogemos horario
			$respuesta = $horario->ADD();//Y lo añadimos
			new Mensaje($respuesta, '../Controllers/Controller_Horario.php');// y a ver qué ha pasado en la BD
		}
		break;
		
	case 'EDIT':
		if(!$_POST){//Si GET
			$horario = new Horario($_REQUEST['Horario'],'', '');//Editar horario seleccionado
			$horario->_getDatosGuardados();//Rellenar con los datos de la BD
			new Horario_EDIT($horario);//Mostrar vista
		}else{
			$horario = get_data_form();//Coger datos
			$respuesta = $horario->EDIT();//Actualizarlos
			new Mensaje($respuesta, '../Controllers/Controller_Horario.php');//A ver que pasa con la BD, qué intrigante
		}
		break;
		
	case 'SEARCH':
		if(!$_POST){//Si GET
			$muestraSEARCH = new Horario_SEARCH();//Mostrar vista buscadora
		}else{
			$horario = get_data_form();//Creamos un horario con los datos introducidos (que no insertarlo en la BD)
			$respuesta = $horario->SEARCH();//Buscamos los datos que se parezcan a los introducidos
			if(!is_string($respuesta)){
				new Horario_SHOWALL($respuesta);
			}else{//sino
				new Mensaje($respuesta, '../Controllers/Controller_Pista.php');//Mensaje de error, que hay muchos
			}
		}
		break;
		
	case 'DELETE':
		if(!$_POST){//Si GET
			$horario = new Horario($_REQUEST['Horario'],'', '');//Coger horario guardado a eliminar
			$horario->_getDatosGuardados();//Rellenar datos
			new Horario_DELETE($horario);//Mostrar vissta 
		}else{//Si confirma borrado llega por post
			$horario = new Horario($_POST['Horario'],'','');//Clave
			$respuesta = $horario->DELETE();//Borrar horario con dicha clave
			new Mensaje($respuesta, '../Controllers/Controller_Horario.php');//A ver qué pasa en la BD
		}
	break;
		
	case 'SHOWCURRENT':
		if(!$_POST){//Si GET
			$horario = new Horario($_REQUEST['Horario'],'', '');//Coger clave del horario
			$respuesta = $horario->SHOWCURRENT();
			if(!is_string($respuesta)){//NO debería ser posible pedir un showcurrent de algo no existente pero si esp osible retornará un string, así que si no es un string es un horario
				$horario->_getDatosGuardados();
				new Horario_SHOWCURRENT($horario);//Mostrar al horario rellenado
			}else{//sino
				new Mensaje($respuesta, '../Controllers/Controller_Horario.php');//Mensaje de error, que hay muchos
			}
		}
		break;
		
	case 'SHOWALL':
		$horario = new Horario('','','');//No necesitamos horario para buscar (pero sí para acceder a la BD)
		$respuesta = $horario->SHOWALL();//Todos los datos de la BD estarán aqúi
		new Horario_SHOWALL($respuesta);//Le pasamos todos los datos de la BD
		break;
		
	default:
		$horario = new Horario('','','');//No necesitamos horario para buscar (pero sí para acceder a la BD)
		$respuesta = $horario->SHOWALL();//Todos los datos de la BD estarán aqúi
		new Horario_SHOWALL($respuesta);//Le pasamos todos los datos de la BD
		break;
}
?>