<?php
/* 
	Controller del campeonato
*/
	session_start();
	include_once '../Functions/Autenticacion.php';
	if(autenticado()){
		if(!isAdmin()){
			$_REQUEST['submit'] = 'INSCRIBIR';
		}
	}else{
		header('Location: ../index.php');
	}
	
	include '../Modelos/Campeonato.php';
	include '../Views/Campeonato/Campeonato_ADD.php';
	include '../Views/Campeonato/Campeonato_EDIT.php';
	include '../Views/Campeonato/Campeonato_SEARCH.php';
	include '../Views/Campeonato/Campeonato_DELETE.php';
	include '../Views/Campeonato/Campeonato_SHOWCURRENT.php';
	include '../Views/Campeonato/Campeonato_SHOWALL.php';
	include '../Modelos/Campeonato_consta_de_categorias.php';
	include '../Views/Campeonato/Campeonato_ADDCATEGORIA.php';
	include '../Views/MESSAGE.php';
	
function get_data_form(){

	if(!isset($_REQUEST['Campeonato'])){
		$_REQUEST['Campeonato'] = 0;
	}
	$Campeonato = $_REQUEST['Campeonato'];
	$FechaInicio = $_REQUEST['FechaInicio'];
	$FechaFinal = $_REQUEST['FechaFinal'];
	$Nombre = $_REQUEST['Nombre'];

	$Campeonato = new Campeonato($Campeonato, $FechaInicio, $FechaFinal,$Nombre);
 
	return $Campeonato;
}
	

if (!isset($_REQUEST['submit'])){ //si no viene del formulario, no existe array POST
	$_REQUEST['submit'] = 'SHOWALL';
}

switch ($_REQUEST['submit']){
	case 'ADD':
		if(!$_POST){//Si GET
			$muestraADD = new Campeonato_ADD();//Mostrar vista add
		}else{
			$Campeonato = get_data_form();//Si post cogemos Campeonato
			$respuesta = $Campeonato->ADD();//Y lo añadimos
			new Mensaje($respuesta, '../Controllers/Controller_Campeonato.php');// y a ver qué ha pasado en la BD
		}
		break;
		
	case 'EDIT':
		if(!$_POST){//Si GET
			$Campeonato = new Campeonato($_REQUEST['Campeonato'],'', '','');//Editar Campeonato seleccionado
			$Campeonato->_getDatosGuardados();//Rellenar con los datos de la BD
			new Campeonato_EDIT($Campeonato);//Mostrar vista
		}else{
			$Campeonato = get_data_form();//Coger datos
			$respuesta = $Campeonato->EDIT();//Actualizarlos
			new Mensaje($respuesta, '../Controllers/Controller_Campeonato.php');//A ver que pasa con la BD, qué intrigante
		}
		break;
		
	case 'SEARCH':
		if(!$_POST){//Si GET
			$muestraSEARCH = new Campeonato_SEARCH();//Mostrar vista buscadora
		}else{
			$Campeonato = get_data_form();//Creamos un Campeonato con los datos introducidos (que no insertarlo en la BD)
			$respuesta = $Campeonato->SEARCH();//Buscamos los datos que se parezcan a los introducidos
			new Campeonato_SHOWALL($respuesta, '');//Mostramos todos los datos recuperados de la BD (showall muestra todos los datos que se le pasan)
		}
		break;
		
	case 'DELETE' :
		if(!$_POST){//Si GET
			$Campeonato = new Campeonato($_REQUEST['Campeonato'],'', '','');//Coger Campeonato guardado a eliminar
			$Campeonato->_getDatosGuardados();//Rellenar datos
			new Campeonato_DELETE($Campeonato);//Mostrar vissta 
		}else{//Si confirma borrado llega por post
			$Campeonato = new Campeonato($_POST['Campeonato'],'','','','');//Clave
			$respuesta = $Campeonato->DELETE();//Borrar Campeonato con dicha clave
			new Mensaje($respuesta, '../Controllers/Controller_Campeonato.php');//A ver qué pasa en la BD
		}
	break;
		
	case 'SHOWCURRENT':
		if(!$_POST){//Si GET
			$Campeonato = new Campeonato($_REQUEST['Campeonato'],'', '','','');//Coger clave del Campeonato
			$respuesta = $Campeonato->SHOWCURRENT();
			if(!is_string($respuesta)){//NO debería ser posible pedir un showcurrent de algo no existente pero si esp osible retornará un string, así que si no es un string es un Campeonato
				$Campeonato->_getDatosGuardados();
				new Campeonato_SHOWCURRENT($Campeonato);//Mostrar al Campeonato rellenado
			}else{//sino
				new Mensaje($respuesta, '../Controllers/Controller_Campeonato.php');//Mensaje de error, que hay muchos
			}
		}
		break;
		

	case 'ADDCATEGORIA':
		if(!$_POST){//Si GET
			$categoriasyCampeonatos = new Campeonato_consta_de_categorias('',$_REQUEST['Campeonato'],'');
			$categoriasyCampeonatos = $categoriasyCampeonatos->CATEGORIASYCAMPEONATOS_UNSET();
		if(is_string($categoriasyCampeonatos)){
			new Mensaje($categoriasyCampeonatos, '../Controllers/Controller_Campeonato.php');// y a ver qué ha pasado en la BD
		}else{
			$muestraADDCAMPEONATO = new Campeonato_ADDCATEGORIA($categoriasyCampeonatos);//Mostrar vista addcategoria
		}
	}else{
		if(!isset($_REQUEST['Categoria'])){
			new Mensaje('No está indicado el codigo de la categoria', '../Controllers/Controller_Campeonato.php');// y a ver qué ha pasado en la BD
		}else{
			$categoriasyCampeonatos = new Campeonato_consta_de_categorias('',$_REQUEST['Campeonato'], $_REQUEST['Categoria']);//Si post cogemos Pista
			$respuesta = $categoriasyCampeonatos->ADD();//Y lo añadimos
			new Mensaje($respuesta, '../Controllers/Controller_Campeonato.php');// y a ver qué ha pasado en la BD
		}
	}
	break;

	case 'SHOWALL':
		$Campeonato = new Campeonato('','','','');//No necesitamos Campeonato para buscar (pero sí para acceder a la BD)
		$respuesta = $Campeonato->SHOWALL();//Todos los datos de la BD estarán aqúi
		new Campeonato_SHOWALL($respuesta, '','','','');//Le pasamos todos los datos de la BD
		break;
		
	default:
		$Campeonato = new Campeonato('','','','');//No necesitamos Campeonato para buscar (pero sí para acceder a la BD)
		$respuesta = $Campeonato->SHOWALL();//Todos los datos de la BD estarán aqúi
		new Campeonato_SHOWALL($respuesta, '','','','');//Le pasamos todos los datos de la BD
		break;
}
?>