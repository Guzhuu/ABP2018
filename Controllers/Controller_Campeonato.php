<?php
/* 
	Controller del campeonato
*/
	session_start();
	include_once '../Functions/Autenticacion.php';
	if(autenticado()){
		if(!isAdmin()){
			$_REQUEST['submit'] = 'SHOWALL';
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
	include '../Views/Campeonato/Campeonato_ADDCATEGORIA.php';
	include '../Views/Campeonato/Campeonato_ESCOGERPAREJA.php';
	include '../Views/Campeonato/Campeonato_SHOWPARAINSCRIBIRSE.php';
	include '../Modelos/Pareja.php';
	include '../Views/Campeonato/Campeonato_CLASIFICACION.php';
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
	
function get_parejaCampeonato_data_form(){
	if(!isset($_REQUEST['codPareja'])){
		$_REQUEST['codPareja'] = 0;
	}
	if(!isset($_REQUEST['DNI_Companhero'])){
		$_REQUEST['DNI_Companhero'] = 0;
	}
	$DNICompanhero = $_REQUEST['DNI_Companhero'];

	$pareja = new Pareja($_SESSION['DNI'], $DNICompanhero);
	$_REQUEST['codPareja'] = $pareja->codPareja;
 
	return $pareja;
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
			$campeonato = new Campeonato($_REQUEST['Campeonato'],'','','');
			$categorias = $campeonato->CATEGORIASYCAMPEONATOS_UNSET();
			if(is_string($categorias)){
				new Mensaje($categorias, '../Controllers/Controller_Campeonato.php');// y a ver qué ha pasado en la BD
			}else{
				new Campeonato_ADDCATEGORIA($categorias);//Mostrar vista addcategoria
			}
		}else{
			if(!isset($_REQUEST['Categoria'])){
				new Mensaje('No está indicada la categoría', '../Controllers/Controller_Campeonato.php');// y a ver qué ha pasado en la BD
			}else{
				if(!isset($_REQUEST['Campeonato'])){
					new Mensaje('No está indicada el campeonato', '../Controllers/Controller_Campeonato.php');// y a ver qué ha pasado en la BD
				}else{
					$campeonato = new Campeonato($_REQUEST['Campeonato'],'','','');//Si post cogemos Pista
					$respuesta = $campeonato->ADDCATEGORIA($_REQUEST['Categoria']);//Y lo añadimos
					new Mensaje($respuesta, '../Controllers/Controller_Campeonato.php?Campeonato=' . $_REQUEST['Campeonato'] . '&submit=ADDCATEGORIA');// y a ver qué ha pasado en la BD
				}
			}
		}
		break;
		

	case 'QUITARCATEGORIA':
		if(!isset($_REQUEST['Categoria'])){
			new Mensaje('No está indicada la categoría', '../Controllers/Controller_Campeonato.php');// y a ver qué ha pasado en la BD
		}else{
			if(!isset($_REQUEST['Campeonato'])){
				new Mensaje('No está indicada el campeonato', '../Controllers/Controller_Campeonato.php');// y a ver qué ha pasado en la BD
			}else{
				$campeonato = new Campeonato($_REQUEST['Campeonato'],'','','');//Si post cogemos Pista
				$respuesta = $campeonato->QUITARCATEGORIA($_REQUEST['Categoria']);//Y lo añadimos
				new Mensaje($respuesta, '../Controllers/Controller_Campeonato.php');// y a ver qué ha pasado en la BD
			}
		}
		break;

	case 'GENERARCALENDARIO':
		if(!isset($_REQUEST['Campeonato'])){
			new Mensaje('No está indicado el campeonato', '../Controllers/Controller_Campeonato.php');// y a ver qué ha pasado en la BD
		}else{
			$campeonato = new Campeonato($_REQUEST['Campeonato'],'','','');//Si post cogemos Pista
			$respuesta = $campeonato->GENERARCALENDARIO();//Y lo añadimos
			if(is_string($respuesta)){
				new Mensaje($respuesta, '../Controllers/Controller_Campeonato.php');// y a ver qué ha pasado en la BD
			}else{
				$mensaje = "";
				for($i = 0; $i < sizeof($respuesta); $i++){
					foreach(array_keys($respuesta[$i]) as $key){
						if($respuesta[$i][$key] === ""){
							$mensaje = $mensaje . "</br>" . $key . ":</br>" . "Grupos generados sin problemas";
						}else{
							$mensaje = $mensaje . "</br>" . $key . ":</br>" . $respuesta[$i][$key];
						}
					}
				}
				new Mensaje($mensaje, '../Controllers/Controller_Campeonato.php');// y a ver qué ha pasado en la BD
			}
		}
		break;
		
	case 'RANKINGGRUPOS':
		if(!isset($_REQUEST['Campeonato'])){
			new Mensaje('No está indicado el campeonato', '../Controllers/Controller_Campeonato.php');// y a ver qué ha pasado en la BD
		}else{
			$campeonato = new Campeonato($_REQUEST['Campeonato'],'','','');//Si post cogemos Pista
			$respuesta = $campeonato->RANKINGGRUPOS();//Y lo añadimos
			if(is_string($respuesta)){
				new Mensaje($respuesta, '../Controllers/Controller_Campeonato.php');// y a ver qué ha pasado en la BD
			}else{
				new Campeonato_CLASIFICACION($respuesta, '../Controllers/Controller_Campeonato.php');// y a ver qué ha pasado en la BD
			}
		}
		break;

	case 'GENERARCUARTOS':
		if(!isset($_REQUEST['Campeonato'])){
			new Mensaje('No está indicado el campeonato', '../Controllers/Controller_Campeonato.php');// y a ver qué ha pasado en la BD
		}else{
			$campeonato = new Campeonato($_REQUEST['Campeonato'],'','','');//Si post cogemos Pista
			$respuesta = $campeonato->GENERARCUARTOS();//Y lo añadimos
			if(is_string($respuesta)){
				new Mensaje($respuesta, '../Controllers/Controller_Campeonato.php');// y a ver qué ha pasado en la BD
			}else{
				$mensaje = "";
				var_dump($respuesta);
				foreach(array_keys($respuesta) as $categoria){
					if($respuesta[$categoria] === ""){
						$mensaje = $mensaje . "</br>" . $categoria . ":</br>" . "Cuartos generados sin problemas";
					}else{
						$mensaje = $mensaje . "</br>" . $categoria . ":</br>" . $respuesta[$categoria];
					}
				}
				new Mensaje($mensaje, '../Controllers/Controller_Campeonato.php');// y a ver qué ha pasado en la BD
			}
		}
		break;
		
	case 'RANKINGFINAL':
		break;

	case 'ESCOGERPAREJA':
		if(!$_POST){//Si GET
			$muestraESCOGERPAREJA = new Campeonato_ESCOGERPAREJA();//Mostrar vista add
		}else{
			$pareja = get_parejaCampeonato_data_form();//Si post cogemos horario
			$respuesta = $pareja->ADD();//Y lo añadimos
			new Mensaje($respuesta, '../Controllers/Controller_Pareja.php');// y a ver qué ha pasado en la BD
		}	
	break;

	case 'SHOWPARAINSCRIBIRSE':

		$Campeonato = new Campeonato('','','','');//No necesitamos Campeonato para buscar (pero sí para acceder a la BD)
		$respuesta = $Campeonato->SHOWALL();//Todos los datos de la BD estarán aqúi
		new Campeonato_SHOWPARAINSCRIBIRSE($respuesta, '','','','');//Le pasamos todos los datos de la BD
	break;

	case 'SHOWALL':
		$Campeonato = new Campeonato('','','','');//No necesitamos Campeonato para buscar (pero sí para acceder a la BD)
		$respuesta = $Campeonato->SHOWALL();//Todos los datos de la BD estarán aqúi
		new Campeonato_SHOWALL($respuesta, '','','','');//Le pasamos todos los datos de la BD
		break;
		
	default:
		new Mensaje("Error", '../index.php');// y a ver qué ha pasado en la BD
		break;
}
?>