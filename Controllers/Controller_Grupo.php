<?php
/* 
	Controller del Grupo
*/
	session_start();
	include_once '../Functions/Autenticacion.php';
	if(!autenticado()){
		header('Location: ../index.php');
	}
	
	include '../Modelos/Grupo.php';
	include '../Views/Grupo/Grupo_ADD.php';
	include '../Views/Grupo/Grupo_EDIT.php';
	include '../Views/Grupo/Grupo_SEARCH.php';
	include '../Views/Grupo/Grupo_DELETE.php';
	include '../Views/Grupo/Grupo_SHOWCURRENT.php';
	include '../Views/Grupo/Grupo_SHOWALL.php';
	include '../Views/MESSAGE.php';
	
function get_data_form(){

if(!isset($_REQUEST['Grupo'])){
		$_REQUEST['Grupo'] = 0;
	}

	$Grupo = $_REQUEST['Grupo'];
	$nombre = $_REQUEST['nombre'];
	$CampeonatoCategoria = $_REQUEST['CampeonatoCategoria'];
	$ParejaCategoria = $_REQUEST['ParejaCategoria'];
	

	$Grupo = new Grupo($Grupo,$nombre,$CampeonatoCategoria,$ParejaCategoria);
 
	return $Grupo;
}
	

if (!isset($_REQUEST['submit'])){ //si no viene del formulario, no existe array POST
	$_REQUEST['submit'] = 'SHOWALL';
}

switch ($_REQUEST['submit']){
	case 'ADD':
		if(!$_POST){//Si GET
			$muestraADD = new Grupo_ADD();//Mostrar vista add
		}else{
			$Grupo = get_data_form();//Si post cogemos Grupo
			$respuesta = $Grupo->ADD();//Y lo añadimos
			new Mensaje($respuesta, '../Controllers/Controller_Grupo.php');// y a ver qué ha pasado en la BD
		}
		break;
		
	case 'EDIT':
		if(!$_POST){//Si GET
			$Grupo = new Grupo($_REQUEST['Grupo'],'','','','');//Editar Grupo seleccionado
			$Grupo->_getDatosGuardados();//Rellenar con los datos del BD
			new Grupo_EDIT($Grupo);//Mostrar vista
		}else{
			$Grupo = get_data_form();//Coger datos
			$respuesta = $Grupo->EDIT();//Actualizarlos
			new Mensaje($respuesta, '../Controllers/Controller_Grupo.php');//A ver que pasa con la BD, qué intrigante
		}
		break;
		
	case 'SEARCH':
		if(!$_POST){//Si GET
			$muestraSEARCH = new Grupo_SEARCH();//Mostrar vista buscadora
		}else{
			$Grupo = get_data_form();//Creamos un Grupo con los datos introducidos (que no insertarlo en la BD)
			$respuesta = $Grupo->SEARCH();//Buscamos los datos que se parezcan a los introducidos
			if(!is_string($respuesta)){
				new Grupo_SHOWALL($respuesta);
			}else{//sino
				new Mensaje($respuesta, '../Controllers/Controller_Grupo.php');//Mensaje de error, que hay muchos
			}
		}
		break;
		
	case 'DELETE' :
		if(!$_POST){//Si GET
			$Grupo = new Grupo($_REQUEST['Grupo'],'','','','');//Coger Grupo guardado a eliminar
			$Grupo->_getDatosGuardados();//Rellenar datos
			new Grupo_DELETE($Grupo);//Mostrar vissta 
		}else{//Si confirma borrado llega por post
			$Grupo = new Grupo($_POST['Grupo'],'','','','');//Clave
			$respuesta = $Grupo->DELETE();//Borrar Grupo con dicha clave
			new Mensaje($respuesta, '../Controllers/Controller_Grupo.php');//A ver qué pasa en la BD
		}
	break;
		
	case 'SHOWCURRENT':
		if(!$_POST){//Si GET
			$Grupo = new Grupo($_REQUEST['Grupo'],'','','','');//Coger clave del Grupo
			$respuesta = $Grupo->SHOWCURRENT();
			if(!is_string($respuesta)){//NO debería ser posible pedir un showcurrent de algo no existente pero si esp osible retornará un string, así que si no es un string es un Grupo
				$Grupo->_getDatosGuardados();
				new Grupo_SHOWCURRENT($Grupo);//Mostrar al Grupo rellenado
			}else{//sino
				new Mensaje($respuesta, '../Controllers/Controller_Grupo.php');//Mensaje de error, que hay muchos
			}
		}
		break;
		
	case 'SHOWALL':
		$Grupo = new Grupo('','','','');//No necesitamos Grupo para buscar (pero sí para acceder a la BD)
		$respuesta = $Grupo->SHOWALL();//Todos los datos del BD estarán aqúi
		new Grupo_SHOWALL($respuesta, '','','','');//Le pasamos todos los datos del BD
		break;
		
	default:
		$Grupo = new Grupo('','','','');//No necesitamos Grupo para buscar (pero sí para acceder a la BD)
		$respuesta = $Grupo->SHOWALL();//Todos los datos del BD estarán aqúi
		new Grupo_SHOWALL($respuesta, '','','','');//Le pasamos todos los datos del BD
		break;
}
?>