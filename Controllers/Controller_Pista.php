<?php
/* 
	Controller de la Pista
*/
	session_start();
	include_once '../Functions/Autenticacion.php';
	if(!isAdmin()){
		header('Location: ../index.php');
	}
	
	include '../Modelos/Pista.php';
	include '../Modelos/pista_tiene_horario.php';
	include '../Views/Pista/Pista_ADD.php';
	include '../Views/Pista/Pista_EDIT.php';
	include '../Views/Pista/Pista_SEARCH.php';
	include '../Views/Pista/Pista_DELETE.php';
	include '../Views/Pista/Pista_SHOWCURRENT.php';
	include '../Views/Pista/Pista_SHOWALL.php';
	include '../Views/Pista/Pista_ADDHORARIO.php';
	include '../Views/MESSAGE.php';
	
function get_data_form(){
	if(!isset($_REQUEST['codigoPista'])){
		$_REQUEST['codigoPista'] = 0;
	}
	$codigoPista = $_REQUEST['codigoPista'];
	$nombre = $_REQUEST['nombre'];

	$Pista = new Pista($codigoPista, $nombre);
 
	return $Pista;
}
	

if (!isset($_REQUEST['submit'])){ //si no viene del formulario, no existe array POST
	$_REQUEST['submit'] = 'SHOWALL';
}

switch ($_REQUEST['submit']){
	case 'ADD':
		if(!$_POST){//Si GET
			$muestraADD = new Pista_ADD();//Mostrar vista add
		}else{
			$Pista = get_data_form();//Si post cogemos Pista
			$respuesta = $Pista->ADD();//Y lo añadimos
			new Mensaje($respuesta, '../Controllers/Controller_Pista.php');// y a ver qué ha pasado en la BD
		}
		break;
		
	case 'ADDHORARIO':
		if(!$_POST){//Si GET
			$pistasyHorarios = new pista_tiene_horario('',$_REQUEST['codigoPista'],'');
			$pistasyHorarios = $pistasyHorarios->PISTASYHORARIOS_UNSET();
			if(is_string($pistasyHorarios)){
				new Mensaje($pistasyHorarios, '../Controllers/Controller_Pista.php');// y a ver qué ha pasado en la BD
			}else{
				$muestraADDHORARIO = new Pista_ADDHORARIO($pistasyHorarios);//Mostrar vista addhorario
			}
		}else{
			if(!isset($_REQUEST['codigoHorario'])){
				new Mensaje('No está indicado el codigo de horario', '../Controllers/Controller_Pista.php');// y a ver qué ha pasado en la BD
			}else{
				$pista_tiene_horario = new pista_tiene_horario('',$_REQUEST['codigoPista'], $_REQUEST['codigoHorario']);//Si post cogemos Pista
				$respuesta = $pista_tiene_horario->ADD();//Y lo añadimos
				new Mensaje($respuesta, '../Controllers/Controller_Pista.php?codigoPista=' . $_REQUEST['codigoPista'] . '&nombre=' . $_REQUEST['nombre'] . '&submit=ADDHORARIO');// y a ver qué ha pasado en la BD
			}
		}
		break;
		
	case 'EDIT':
		if(!$_POST){//Si GET
			$Pista = new Pista($_REQUEST['codigoPista'],'');//Editar Pista seleccionado
			$Pista->_getDatosGuardados();//Rellenar con los datos de la BD
			new Pista_EDIT($Pista);//Mostrar vista
		}else{
			$Pista = get_data_form();//Coger datos
			$respuesta = $Pista->EDIT();//Actualizarlos
			new Mensaje($respuesta, '../Controllers/Controller_Pista.php');//A ver que pasa con la BD, qué intrigante
		}
		break;
		
	case 'SEARCH':
		if(!$_POST){//Si GET
			$muestraSEARCH = new Pista_SEARCH();//Mostrar vista buscadora
		}else{
			$Pista = get_data_form();//Creamos un Pista con los datos introducidos (que no insertarlo en la BD)
			$respuesta = $Pista->SEARCH();//Buscamos los datos que se parezcan a los introducidos
			if(!is_string($respuesta)){
				new Pista_SHOWALL($respuesta);
			}else{//sino
				new Mensaje($respuesta, '../Controllers/Controller_Pista.php');//Mensaje de error, que hay muchos
			}
		}
		break;
		
	case 'DELETE':
		if(!$_POST){//Si GET
			$Pista = new Pista($_REQUEST['codigoPista'],'');//Coger Pista guardado a eliminar
			$Pista->_getDatosGuardados();//Rellenar datos
			new Pista_DELETE($Pista);//Mostrar vissta 
		}else{//Si confirma borrado llega por post
			$Pista = new Pista($_POST['codigoPista'],'','');//Clave
			$respuesta = $Pista->DELETE();//Borrar Pista con dicha clave
			new Mensaje($respuesta, '../Controllers/Controller_Pista.php');//A ver qué pasa en la BD
		}
	break;
		
	case 'SHOWCURRENT':
		if(!$_POST){//Si GET
			$Pista = new Pista($_REQUEST['codigoPista'],'');//Coger clave del Pista
			$respuesta = $Pista->SHOWCURRENT();
			if(!is_string($respuesta)){//NO debería ser posible pedir un showcurrent de algo no existente pero si esp osible retornará un string, así que si no es un string es un Pista
				$Pista->_getDatosGuardados();
				new Pista_SHOWCURRENT($Pista);//Mostrar al Pista rellenado
			}else{//sino
				new Mensaje($respuesta, '../Controllers/Controller_Pista.php');//Mensaje de error, que hay muchos
			}
		}
		break;
		
	case 'SHOWALL':
		$Pista = new Pista('','');//No necesitamos Pista para buscar (pero sí para acceder a la BD)
		$respuesta = $Pista->SHOWALL();//Todos los datos de la BD estarán aqúi
		new Pista_SHOWALL($respuesta, '');//Le pasamos todos los datos de la BD
		break;
		
	default:
		$Pista = new Pista('','');//No necesitamos Pista para buscar (pero sí para acceder a la BD)
		$respuesta = $Pista->SHOWALL();//Todos los datos de la BD estarán aqúi
		new Pista_SHOWALL($respuesta, '');//Le pasamos todos los datos de la BD
		break;
}
?>