<?php /*      Controller del Enfrentamiento */     session_start();
include_once '../Functions/Autenticacion.php';     if(!autenticado()){
header('Location: ../index.php');     }	
	
	include '../Modelos/Enfrentamiento.php';
	include '../Views/Enfrentamiento/Enfrentamiento_ADD.php';
	include '../Views/Enfrentamiento/Enfrentamiento_EDIT.php';
	include '../Views/Enfrentamiento/Enfrentamiento_SEARCH.php';
	include '../Views/Enfrentamiento/Enfrentamiento_DELETE.php';
	include '../Views/Enfrentamiento/Enfrentamiento_SHOWCURRENT.php';
	include '../Views/Enfrentamiento/Enfrentamiento_SHOWALL.php';
	include '../Views/MESSAGE.php';
	
function get_data_form(){

if(!isset($_REQUEST['Enfrentamiento'])){
		$_REQUEST['Enfrentamiento'] = 0;
	}

	$Enfrentamiento = $_REQUEST['Enfrentamiento'];
	$Nombre = $_REQUEST['Nombre'];
	if($Nombre == ''){
		$Nombre = null;
	}
	$CampeonatoCategoria = $_REQUEST['CampeonatoCategoria'];
	$Pareja1 = $_REQUEST['Pareja1'];
	$Pareja2 = $_REQUEST['Pareja2'];
	$set1 = $_REQUEST['set1'];
	$set2 = $_REQUEST['set2'];
	$set3 = $_REQUEST['set3'];
	
	
	$Enfrentamiento = new Enfrentamiento($Enfrentamiento,$Nombre, $CampeonatoCategoria, $Pareja1, $Pareja2, $set1, $set2, $set3);
 
	return $Enfrentamiento;
}
	


if (!isset($_REQUEST['submit'])){ //si no viene del formulario, no existe array POST
	$_REQUEST['submit'] = 'SHOWALL';
}

switch ($_REQUEST['submit']){
	case 'ADD':
		if(!$_POST){//Si GET
			$muestraADD = new Enfrentamiento_ADD();//Mostrar vista add
		}else{
			$Enfrentamiento = get_data_form();//Si post cogemos Enfrentamiento
			$respuesta = $Enfrentamiento->ADD();//Y lo añadimos
			new Mensaje($respuesta, '../Controllers/Controller_Enfrentamiento.php');// y a ver qué ha pasado en la BD
		}
		break;
		
	case 'EDIT':
		if(!$_POST){//Si GET
			$Enfrentamiento = new Enfrentamiento($_REQUEST['Enfrentamiento'],'','','','','','','','');//Editar Enfrentamiento seleccionado
			$Enfrentamiento->_getDatosGuardados();//Rellenar con los datos del BD
			new Enfrentamiento_EDIT($Enfrentamiento);//Mostrar vista
		}else{
			$Enfrentamiento = get_data_form();//Coger datos
			$respuesta = $Enfrentamiento->EDIT();//Actualizarlos
			new Mensaje($respuesta, '../Controllers/Controller_Enfrentamiento.php');//A ver que pasa con la BD, qué intrigante
		}
		break;
		
	case 'SEARCH':
		if(!$_POST){//Si GET
			$muestraSEARCH = new Enfrentamiento_SEARCH();//Mostrar vista buscadora
		}else{
			$Enfrentamiento = get_data_form();//Creamos un Grupo con los datos introducidos (que no insertarlo en la BD)
			$respuesta = $Enfrentamiento->SEARCH();//Buscamos los datos que se parezcan a los introducidos
			if(!is_string($respuesta)){
				new Enfrentamiento_SHOWALL($respuesta);
			}else{//sino
				new Mensaje($respuesta, '../Controllers/Controller_Enfrentamiento.php');//Mensaje de error, que hay muchos
			}
		}
		break;
		
		
	case 'DELETE' :
		if(!$_POST){//Si GET
			$Enfrentamiento = new Enfrentamiento($_REQUEST['Enfrentamiento'],'','','','','','','','');//Coger Enfrentamiento guardado a eliminar
			$Enfrentamiento->_getDatosGuardados();//Rellenar datos
			new Enfrentamiento_DELETE($Enfrentamiento);//Mostrar vissta 
		}else{//Si confirma borrado llega por post
			$Enfrentamiento = new Enfrentamiento($_POST['Enfrentamiento'],'','','','','','','','');//Clave
			$respuesta = $Enfrentamiento->DELETE();//Borrar Enfrentamiento con dicha clave
			new Mensaje($respuesta, '../Controllers/Controller_Enfrentamiento.php');//A ver qué pasa en la BD
		}
	break;
		
	case 'SHOWCURRENT':
		if(!$_POST){//Si GET
			$Enfrentamiento = new Enfrentamiento($_REQUEST['Enfrentamiento'],'','','','','','','','');//Coger clave del Enfrentamiento
			$respuesta = $Enfrentamiento->SHOWCURRENT();
			if(!is_string($respuesta)){//NO debería ser posible pedir un showcurrent de algo no existente pero si esp osible retornará un string, así que si no es un string es un Enfrentamiento
				$Enfrentamiento->_getDatosGuardados();
				new Enfrentamiento_SHOWCURRENT($Enfrentamiento);//Mostrar al Enfrentamiento rellenado
			}else{//sino
				new Mensaje($respuesta, '../Controllers/Controller_Enfrentamiento.php');//Mensaje de error, que hay muchos
			}
		}
		break;
		
	case 'SHOWALL':
		$Enfrentamiento = new Enfrentamiento('','','','','','','','');//No necesitamos Enfrentamiento para buscar (pero sí para acceder a la BD)
		$Deportistas = $Enfrentamiento->DEPORTISTASENFRENTAMIENTO();
		$respuesta = $Enfrentamiento->SHOWALL();//Todos los datos del BD estarán aqúi
		new Enfrentamiento_SHOWALL($respuesta, $Deportistas);//Le pasamos todos los datos del BD
		break;
		
	default:
		new Mensaje("Error", '../index.php');// y a ver qué ha pasado en la BD
		break;
}
?>