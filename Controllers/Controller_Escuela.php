<?php
/* 
	Controller de clases
*/
	session_start();
	include_once '../Functions/Autenticacion.php';
	if(!isAdmin()){
		header('Location: ../index.php');
	}
	
	include '../Modelos/Escuela.php';
	
	include '../Views/Escuela/Escuela_EDIT.php';
	include '../Views/Escuela/Escuela_SEARCH.php';
	include '../Views/Escuela/Escuela_DELETE.php';
	include '../Views/Escuela/Escuela_SHOWCURRENT.php';
	include '../Views/Escuela/Escuela_ADD.php';
	include '../Views/Escuela/Escuela_SHOWALL.php';
	include '../Views/MESSAGE.php';
	
function get_data_form(){
	if(!isset($_REQUEST['codigoEscuela'])){
		$_REQUEST['codigoEscuela'] = null;
	}
	$Escuela = $_REQUEST['codigoEscuela'];
	$Nombre = $_REQUEST['nombreEscuela'];

	$escuela = new Escuela($Escuela, $Nombre);
 
	return $escuela;
}
	

if (!isset($_REQUEST['submit'])){ //si no viene del formulario, no existe array POST
	$_REQUEST['submit'] = 'SHOWALL';
}

switch ($_REQUEST['submit']){
	case 'ADD':
		if(!$_POST){//Si GET
			$muestraADD = new Escuela_ADD();//Mostrar vista add
		}else{
			$clase = get_data_form();//Si post cogemos clase
			$respuesta = $clase->ADD();//Y lo añadimos
			new Mensaje($respuesta, '../Controllers/Controller_Escuela.php');// y a ver qué ha pasado en la BD
		}
		break;
		
	case 'EDIT':
		if(!$_POST){//Si GET
			$clase = new Escuela($_REQUEST['codigoEscuela'],'');//Editar clase seleccionado
			$clase->_getDatosGuardados();//Rellenar con los datos de la BD
			new Escuela_EDIT($clase);//Mostrar vista
		}else{
			$clase = get_data_form();//Coger datos
			$respuesta = $clase->EDIT();//Actualizarlos
			new Mensaje($respuesta, '../Controllers/Controller_Escuela.php');//A ver que pasa con la BD, qué intrigante
		}
		break;
		
	case 'SEARCH':
		if(!$_POST){//Si GET
			$muestraSEARCH = new Escuela_SEARCH();//Mostrar vista buscadora
		}else{
			$clase = get_data_form();//Creamos un clase con los datos introducidos (que no insertarlo en la BD)
			$respuesta = $clase->SEARCH();//Buscamos los datos que se parezcan a los introducidos
			if(!is_string($respuesta)){
				new Escuela_SHOWALL($respuesta);
			}else{//sino
				new Mensaje($respuesta, '../Controllers/Controller_Escuela.php');//Mensaje de error, que hay muchos
			}
		}
		break;
		
	case 'DELETE':
		if(!$_POST){//Si GET
			$clase = new Escuela($_REQUEST['codigoEscuela'],'');//Coger clase guardado a eliminar
			$clase->_getDatosGuardados();//Rellenar datos
			new Escuela_DELETE($clase);//Mostrar vissta 
		}else{//Si confirma borrado llega por post
			$clase = new Escuela($_POST['codigoEscuela'],'');//Clave
			$respuesta = $clase->DELETE();//Borrar clase con dicha clave
			new Mensaje($respuesta, '../Controllers/Controller_Escuela.php');//A ver qué pasa en la BD
		}
	break;
		
	case 'SHOWCURRENT':
		if(!$_POST){//Si GET
			$clase = new Escuela($_REQUEST['codigoEscuela'],'');//Coger clave del clase
			$respuesta = $clase->SHOWCURRENT();
			if(!is_string($respuesta)){//NO debería ser posible pedir un showcurrent de algo no existente pero si esp osible retornará un string, así que si no es un string es un clase
				$clase->_getDatosGuardados();
				new Escuela_SHOWCURRENT($clase);//Mostrar al clase rellenado
			}else{//sino
				new Mensaje($respuesta, '../Controllers/Controller_Escuela.php');//Mensaje de error, que hay muchos
			}
		}
		break;
		
	case 'SHOWALL':
		$respuesta = null;
		$clase = new Escuela('','');//No necesitamos clase para buscar (pero sí para acceder a la BD)
		$respuesta = $clase->SHOWALL();//Todos los datos de la BD estarán aqúi
		new Escuela_SHOWALL($respuesta);//Le pasamos todos los datos de la BD
		break;
		
	default:
		$clase = new Escuela('','');//No necesitamos clase para buscar (pero sí para acceder a la BD)
		$respuesta = $clase->SHOWALL();//Todos los datos de la BD estarán aqúi
		new Escuela_SHOWALL($respuesta);//Le pasamos todos los datos de la BD
		break;
}
?>