<?php
/* 
	Controller de la Categoria
*/
	session_start();
	include_once '../Functions/Autenticacion.php';
	if(!autenticado()){
		header('Location: ../index.php');
	}
	
	include '../Modelos/Categoria.php';
	include '../Views/Categoria/Categoria_ADD.php';
	include '../Views/Categoria/Categoria_EDIT.php';
	include '../Views/Categoria/Categoria_SEARCH.php';
	include '../Views/Categoria/Categoria_DELETE.php';
	include '../Views/Categoria/Categoria_SHOWCURRENT.php';
	include '../Views/Categoria/Categoria_SHOWALL.php';
	include '../Views/MESSAGE.php';
	
function get_data_form(){

if(!isset($_REQUEST['Categoria'])){
		$_REQUEST['Categoria'] = 0;
	}

	$Categoria = $_REQUEST['Categoria'];
	$Nivel = $_REQUEST['Nivel'];
	
	$sexos = array('M', 'F', 'MX');
	if(isset($_REQUEST['Sexo']) && in_array($_REQUEST['Sexo'], $sexos)){
		$Sexo = $_REQUEST['Sexo'];
	}else{
		$Sexo = 'MX';
	}
	
	$Categoria = new Categoria($Categoria, $Nivel, $Sexo);
 
	return $Categoria;
}
	

if (!isset($_REQUEST['submit'])){ //si no viene de la formulario, no existe array POST
	$_REQUEST['submit'] = 'SHOWALL';
}

switch ($_REQUEST['submit']){
	case 'ADD':
		if(!$_POST){//Si GET
			$muestraADD = new Categoria_ADD();//Mostrar vista add
		}else{
			$Categoria = get_data_form();//Si post cogemos Categoria
			$respuesta = $Categoria->ADD();//Y lo añadimos
			new Mensaje($respuesta, '../Controllers/Controller_Categoria.php');// y a ver qué ha pasado en la BD
		}
		break;
		
	case 'EDIT':
		if(!$_POST){//Si GET
			$Categoria = new Categoria($_REQUEST['Categoria'],'', '','');//Editar Categoria seleccionado
			$Categoria->_getDatosGuardados();//Rellenar con los datos de la BD
			new Categoria_EDIT($Categoria);//Mostrar vista
		}else{
			$Categoria = get_data_form();//Coger datos
			$respuesta = $Categoria->EDIT();//Actualizarlos
			new Mensaje($respuesta, '../Controllers/Controller_Categoria.php');//A ver que pasa con la BD, qué intrigante
		}
		break;
		
	case 'SEARCH':
		if(!$_POST){//Si GET
			$muestraSEARCH = new Categoria_SEARCH();//Mostrar vista buscadora
		}else{
			$Categoria = get_data_form();//Creamos un Categoria con los datos introducidos (que no insertarlo en la BD)
			$respuesta = $Categoria->SEARCH();//Buscamos los datos que se parezcan a los introducidos
			new Categoria_SHOWALL($respuesta, '');//Mostramos todos los datos recuperados de la BD (showall muestra todos los datos que se le pasan)
		}
		break;
		
	case 'DELETE' :
		if(!$_POST){//Si GET
			$Categoria = new Categoria($_REQUEST['Categoria'],'', '','');//Coger Categoria guardado a eliminar
			$Categoria->_getDatosGuardados();//Rellenar datos
			new Categoria_DELETE($Categoria);//Mostrar vissta 
		}else{//Si confirma borrado llega por post
			$Categoria = new Categoria($_POST['Categoria'],'','','');//Clave
			$respuesta = $Categoria->DELETE();//Borrar Categoria con dicha clave
			new Mensaje($respuesta, '../Controllers/Controller_Categoria.php');//A ver qué pasa en la BD
		}
	break;
		
	case 'SHOWCURRENT':
		if(!$_POST){//Si GET
			$Categoria = new Categoria($_REQUEST['Categoria'],'', '','');//Coger clave de la Categoria
			$respuesta = $Categoria->SHOWCURRENT();
			if(!is_string($respuesta)){//NO debería ser posible pedir un showcurrent de algo no existente pero si esp osible retornará un string, así que si no es un string es un Categoria
				$Categoria->_getDatosGuardados();
				new Categoria_SHOWCURRENT($Categoria);//Mostrar al Categoria rellenado
			}else{//sino
				new Mensaje($respuesta, '../Controllers/Controller_Categoria.php');//Mensaje de error, que hay muchos
			}
		}
		break;
		
	case 'SHOWALL':
		$Categoria = new Categoria('','','');//No necesitamos Categoria para buscar (pero sí para acceder a la BD)
		$respuesta = $Categoria->SHOWALL();//Todos los datos de la BD estarán aqúi
		new Categoria_SHOWALL($respuesta, '','','');//Le pasamos todos los datos de la BD
		break;
		
	default:
		$Categoria = new Categoria('','','');//No necesitamos Categoria para buscar (pero sí para acceder a la BD)
		$respuesta = $Categoria->SHOWALL();//Todos los datos de la BD estarán aqúi
		new Categoria_SHOWALL($respuesta, '','','');//Le pasamos todos los datos de la BD
		break;
}

?>