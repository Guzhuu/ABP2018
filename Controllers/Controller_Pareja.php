<?php
/* 
	Controller del Horario
*/
	session_start();
	include_once '../Functions/Autenticacion.php';
	if(autenticado()){
		if(!isAdmin()){
			if(isset($_REQUEST['submit'])){
				if($_REQUEST['submit']!='SHOWALLFORUSER' && $_REQUEST['submit']!='VERCAMPEONATOS' && $_REQUEST['submit']!='ADD' && $_REQUEST['submit']!='SEARCH' && $_REQUEST['submit']!='DELETE' && $_REQUEST['submit']!='SHOWCURRENT' && $_REQUEST['submit']!='EDIT'){
					$_REQUEST['submit'] = 'SHOWALLFORUSER';
				}
			}else{
				$_REQUEST['submit'] = 'SHOWALLFORUSER';
			}
		}
	}
	else{
		header('Location: ../index.php');
	}
	
	include '../Modelos/Pareja.php';
	include '../Modelos/Pareja_pertenece_categoria.php';
	include '../Views/Pareja/Pareja_EDIT.php';
	include '../Views/Pareja/Pareja_SEARCH.php';
	include '../Views/Pareja/Pareja_DELETE.php';
	include '../Views/Pareja/Pareja_SHOWCURRENT.php';
	include '../Views/Pareja/Pareja_ADD.php';
	include '../Views/Pareja/Pareja_SHOWALL.php';
	include '../Views/Pareja/Pareja_SHOWALLFORUSER.php';
	include '../Views/Pareja/Pareja_ESCOGERPAREJA.php';
	include '../Views/Campeonato/Campeonato_SHOWPARAINSCRIBIRSE.php';
	include '../Views/Campeonato/Campeonato_MISPAREJASESCOGERNIVEL.php';
	include '../Modelos/Campeonato.php';
	include '../Views/MESSAGE.php';
	
function get_data_form(){
	if(!isset($_REQUEST['codPareja'])){
		$_REQUEST['codPareja'] = 0;
	}
	$codPareja = $_REQUEST['codPareja'];
	$DNI_Capitan = $_REQUEST['DNI_Capitan'];
	$DNI_Companhero = $_REQUEST['DNI_Companhero'];


	$pareja = new Pareja('',$DNI_Capitan, $DNI_Companhero);
	$_REQUEST['codPareja'] = $pareja->codPareja;
 
	return $pareja;
}
	
function get_parejaCampeonato_data_form(){
	if(!isset($_REQUEST['codPareja'])){
		$_REQUEST['codPareja'] = 0;
	}
	if(!isset($_REQUEST['DNI_Companhero'])){
		$_REQUEST['DNI_Companhero'] = 0;
	}
	$DNICompanhero = $_REQUEST['DNI_Companhero'];

	$pareja = new Pareja('',$_SESSION['DNI'], $DNICompanhero);
	$_REQUEST['codPareja'] = $pareja->codPareja;
 
	return $pareja;
}




if (!isset($_REQUEST['submit'])){ //si no viene del formulario, no existe array POST
	$_REQUEST['submit'] = 'SHOWALL';
}

switch ($_REQUEST['submit']){
	case 'ADD':
		if(!$_POST){//Si GET
			$muestraADD = new Pareja_ADD();//Mostrar vista add
		}else{
			$pareja = get_data_form();//Si post cogemos horario
			$respuesta = $pareja->ADD();//Y lo añadimos
			new Mensaje($respuesta, '../Controllers/Controller_Pareja.php');// y a ver qué ha pasado en la BD
		}
		break;
		
	case 'EDIT':
		if(!$_POST){//Si GET
			$pareja = new Pareja($_REQUEST['codPareja'],'', '');//Editar horario seleccionado
			$pareja->_getDatosGuardados();//Rellenar con los datos de la BD
			new Pareja_EDIT($pareja);//Mostrar vista
		}else{
			$pareja = get_data_form();//Coger datos
			$respuesta = $pareja->EDIT();//Actualizarlos
			new Mensaje($respuesta, '../Controllers/Controller_Pareja.php');//A ver que pasa con la BD, qué intrigante
		}
		break;
		
	case 'SEARCH':
		if(!$_POST){//Si GET
			$muestraSEARCH = new Pareja_SEARCH();//Mostrar vista buscadora
		}else{
			$pareja = get_data_form();//Creamos un horario con los datos introducidos (que no insertarlo en la BD)
			var_dump($pareja);
			$respuesta = $pareja->SEARCH();//Buscamos los datos que se parezcan a los introducidos
			if(!is_string($respuesta)){
				new Pareja_SHOWALLFORUSER($respuesta);
			}else{//sino
				new Mensaje($respuesta, '../Controllers/Controller_Pareja.php');//Mensaje de error, que hay muchos
			}
		}
		break;
		
	case 'DELETE':
		if(!$_POST){//Si GET
			$pareja = new Pareja($_REQUEST['codPareja'],'', '');//Coger horario guardado a eliminar
			$pareja->_getDatosGuardados();//Rellenar datos
			new Pareja_DELETE($pareja);//Mostrar vissta 
		}else{//Si confirma borrado llega por post
			$pareja = new Pareja($_POST['codPareja'],'','');//Clave
			$respuesta = $pareja->DELETE();//Borrar horario con dicha clave
			new Mensaje($respuesta, '../Controllers/Controller_Pareja.php');//A ver qué pasa en la BD
		}
	break;
		
	case 'SHOWCURRENT':
		if(!$_POST){//Si GET
			$pareja = new Pareja($_REQUEST['codPareja'],'', '');//Coger clave del horario
			$respuesta = $pareja->SHOWCURRENT();
			if(!is_string($respuesta)){//NO debería ser posible pedir un showcurrent de algo no existente pero si esp osible retornará un string, así que si no es un string es un horario
				$pareja->_getDatosGuardados();
				new Pareja_SHOWCURRENT($pareja);//Mostrar al horario rellenado
			}else{//sino
				new Mensaje($respuesta, '../Controllers/Controller_Pareja.php');//Mensaje de error, que hay muchos
			}
		}
		break;
		
	case 'SHOWALL':
		$pareja = new Pareja('','','');//No necesitamos horario para buscar (pero sí para acceder a la BD)
		$respuesta = $pareja->SHOWALL();//Todos los datos de la BD estarán aqúi
		new Pareja_SHOWALL($respuesta);//Le pasamos todos los datos de la BD
		break;

	case 'SHOWALLPAREJACATEGORIA':
		$parejaPerteneceCategoria = new Pareja_pertenece_categoria('','','');//No necesitamos horario para buscar (pero sí para acceder a la BD)
		$respuesta = $parejaPerteneceCategoria->SHOWALL();//Todos los datos de la BD estarán aqúi
		new Pareja_SHOWALLPAREJACATEGORIA($respuesta);//Le pasamos todos los datos de la BD
		break;

	case 'VERCAMPEONATOS':
		if(!$_POST){//Si GET
			$Campeonato = new Campeonato('','','','');
			$Categorias=$Campeonato->CATEGORIAS();
			$Pareja= new Pareja($_REQUEST['codPareja'],'','');
			$Pareja->_getDatosGuardados();
			$muestraESCOGERPAREJA = new Campeonato_MISPAREJASESCOGERNIVEL($Categorias, $Pareja);//Mostrar vista add
		}else{
			$parejaPerteneceCategoria = get_parejaCampeonato_data_form();//Si post cogemos horario
			if($parejaPerteneceCategoria!=NULL){
				$respuesta = $parejaPerteneceCategoria->ADD();//Y lo añadimos
				//var_dump($respuesta);
				$CategoriaDePareja= $parejaPerteneceCategoria->Categoria_Categoria;
				$CodigoDePareja= $parejaPerteneceCategoria->Pareja_codPareja;
				$parejaPerteneceCategoria->_getCodigo($CodigoDePareja,$CategoriaDePareja);
				//var_dump($CategoriaDePareja);
				//new Mensaje($respuesta, '../Controllers/Controller_Pareja.php');// y a ver qué ha pasado en la BD
				$Campeonato = new Campeonato('','','','');
				$respuesta = $Campeonato->SHOWALLCONCATEGORIASCOMPATIBLES($parejaPerteneceCategoria);//Todos los datos de la BD estarán aqúi
			new Campeonato_SHOWPARAINSCRIBIRSE($respuesta, $parejaPerteneceCategoria,'','','','');
			}
		}
			
	break;
	case 'SHOWALLFORUSER':
		$pareja = new Pareja('','','');//No necesitamos horario para buscar (pero sí para acceder a la BD)
		$respuesta = $pareja->SHOWALL();//Todos los datos de la BD estarán aqúi
		new Pareja_SHOWALLFORUSER($respuesta);//Le pasamos todos los datos de la BD
		break;

	default:
		$pareja = new Pareja('','','');//No necesitamos horario para buscar (pero sí para acceder a la BD)
		$respuesta = $pareja->SHOWALL();//Todos los datos de la BD estarán aqúi
		new Pareja_SHOWALL($respuesta);//Le pasamos todos los datos de la BD
		break;
}
?>