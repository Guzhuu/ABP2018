<?php
/* 
	Controller de clases hola
*/
	session_start();
	include_once '../Functions/Autenticacion.php';
	if(!(isAdmin() || isEntrenador())){
		header('Location: ../index.php');
	}
	
	include '../Modelos/Clase.php';
	
	include '../Views/Clase/Clase_EDIT.php';
	include '../Views/Clase/Clase_SEARCH.php';
	include '../Views/Clase/Clase_DELETE.php';
	include '../Views/Clase/Clase_ANULARCLASE.php';
	include '../Views/Clase/Clase_ANULARCURSO.php';
	include '../Views/Clase/Clase_SHOWCURRENT.php';
	include '../Views/Clase/Clase_ADD.php';
	include '../Views/Clase/Clase_SHOWALL.php';
	include '../Views/Clase/Clase_SHOWALLFROM.php';
	include '../Views/MESSAGE.php';
	
	
function get_data_form(){
	$Clase = $_REQUEST['Clase'];
	$Reserva = $_REQUEST['Reserva_Reserva'];
	$codigoEscuela = $_REQUEST['codigoEscuela'];
	$Entrenador = $_REQUEST['Entrenador'];
	$Curso = $_REQUEST['Curso'];

	$clase = new Clase($Clase, $Reserva, $codigoEscuela, $Entrenador, $Curso);
 
	return $clase;
}
	

if (!isset($_REQUEST['submit'])){ //si no viene del formulario, no existe array POST
	if(isAdmin()){
		$_REQUEST['submit'] = 'SHOWALL';
	}else{
		$accionesPermitidasEntrenador = array("EDITHORARIO", "SHOWALLFROM", "ANULARCURSO", "ANULARCLASE");
		if(isset($_SESSION['DNI'])){
			if(!isset($_REQUEST['submit']) || !in_array($_REQUEST['submit'], $accionesPermitidasEntrenador)){
				$_REQUEST['submit'] = 'SHOWALL';
			}
		}else{
			new Mensaje("Error de login", '../index.php');
		}
	}
}

switch ($_REQUEST['submit']){
	case 'ADD':
		if(!$_POST){//Si GET
			$muestraADD = new Clase_ADD();//Mostrar vista add
		}else{
			$clase = get_data_form();//Si post cogemos clase
			$respuesta = $clase->ADD();//Y lo añadimos
			new Mensaje($respuesta, '../Controllers/Controller_Clase.php');// y a ver qué ha pasado en la BD
		}
		break;
		
	case 'EDIT':
		if(!$_POST){//Si GET
			$clase = new Clase($_REQUEST['Clase'],'','','', '');//Editar clase seleccionado
			$clase->_getDatosGuardados();//Rellenar con los datos de la BD
			new Clase_EDIT($clase);//Mostrar vista
		}else{
			$clase = get_data_form();//Coger datos
			$respuesta = $clase->EDIT();//Actualizarlos
			new Mensaje($respuesta, '../Controllers/Controller_Clase.php');//A ver que pasa con la BD, qué intrigante
		}
		break;
		
	case 'SEARCH':
		if(!$_POST){//Si GET
			$muestraSEARCH = new Clase_SEARCH();//Mostrar vista buscadora
		}else{
			$clase = get_data_form();//Creamos un clase con los datos introducidos (que no insertarlo en la BD)
			$respuesta = $clase->SEARCH();//Buscamos los datos que se parezcan a los introducidos
			if(!is_string($respuesta)){
				new Clase_SHOWALL($respuesta);
			}else{//sino
				new Mensaje($respuesta, '../Controllers/Controller_Clase.php');//Mensaje de error, que hay muchos
			}
		}
		break;
		
	case 'DELETE':
		if(!$_POST){//Si GET
			$clase = new Clase($_REQUEST['Clase'],'','','', '');//Coger clase guardado a eliminar
			$clase->_getDatosGuardados();//Rellenar datos
			new Clase_DELETE($clase);//Mostrar vissta 
		}else{//Si confirma borrado llega por post
			$clase = new Clase($_POST['Clase'],'','','', '');//Clave
			$respuesta = $clase->DELETE();//Borrar clase con dicha clave
			new Mensaje($respuesta, '../Controllers/Controller_Clase.php');//A ver qué pasa en la BD
		}
	break;
		
	case 'ANULARCLASE':
		if(!$_POST){//Si GET
			$clase = new Clase($_REQUEST['Clase'],'','','','');//Coger clase guardado a eliminar
			$clase->_getDatosGuardados();//Rellenar datos
			$respuesta = $clase->DETALLES();
			if(is_string($respuesta)){
				new Mensaje($respuesta, '../Controllers/Controller_Clase.php');//Mensaje de error, que hay muchos
			}else{
				new Clase_ANULARCLASE($respuesta);//Mostrar vissta 
			}
		}else{//Si confirma borrado llega por post
			$clase = new Clase($_POST['Clase'],'','','','');//Clave
			$clase->_getDatosGuardados();
			$respuesta = $clase->ANULARCLASE();//Borrar curso con dicha clave
			new Mensaje($respuesta, '../Controllers/Controller_Clase.php');//A ver qué pasa en la BD
		}
		break;
		
	case 'ANULARCURSO':
		if(!$_POST){//Si GET
			$clase = new Clase($_REQUEST['Clase'],'','','','');//Coger clase guardado a eliminar
			$clase->_getDatosGuardados();//Rellenar datos
			$respuesta = $clase->CURSO();
			if(is_string($respuesta)){
				new Mensaje($respuesta, '../Controllers/Controller_Clase.php');//Mensaje de error, que hay muchos
			}else{
				new Clase_ANULARCURSO($respuesta);//Mostrar vissta 
			}
		}else{//Si confirma borrado llega por post
			$clase = new Clase($_POST['Clase'],'','','','');//Clave
			$clase->_getDatosGuardados();
			$respuesta = $clase->ANULARCURSO();//Borrar curso con dicha clave
			new Mensaje($respuesta, '../Controllers/Controller_Clase.php');//A ver qué pasa en la BD
		}
		break;
		
	case 'EDITHORARIO':
		break;
		
	case 'SHOWCURRENT':
		if(!$_POST){//Si GET
			$clase = new Clase($_REQUEST['Clase'],'','','', '');//Coger clave del clase
			$respuesta = $clase->SHOWCURRENT();
			if(!is_string($respuesta)){//NO debería ser posible pedir un showcurrent de algo no existente pero si esp osible retornará un string, así que si no es un string es un clase
				$clase->_getDatosGuardados();
				new Clase_SHOWCURRENT($clase);//Mostrar al clase rellenado
			}else{//sino
				new Mensaje($respuesta, '../Controllers/Controller_Clase.php');//Mensaje de error, que hay muchos
			}
		}
		break;
		
	case 'SHOWALL':
		$respuesta = null;
		if(!isAdmin()){
			$clase = new Clase('','','',$_SESSION['DNI'], '');//No necesitamos clase para buscar (pero sí para acceder a la BD)
			$respuesta = $clase->SHOWALLFROM();//Todos los datos de la BD que tenga su dni
			if(!is_string($respuesta)){
				new Clase_SHOWALLFROM($respuesta);//Le pasamos todos los datos de la BD
			}else{
				new Clase_SHOWALLFROM($respuesta);
			}
		}else{
			$clase = new Clase('','','','', '');//No necesitamos clase para buscar (pero sí para acceder a la BD)
			$respuesta = $clase->SHOWALL();//Todos los datos de la BD estarán aqúi
			new Clase_SHOWALL($respuesta);//Le pasamos todos los datos de la BD
		}
		break;
	
		
	default:
		new Mensaje("Error de login", '../index.php');
		break;
}
?>