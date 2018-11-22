<?php
/* 
	Controller de la reserva
*/
	session_start();
	include_once '../Functions/Autenticacion.php';
	if(!autenticado()){
		header('Location: ../index.php');
	}
	
	include '../Modelos/Reserva.php';
	include '../Modelos/Pista.php';
	include '../Views/Reserva/Reserva_ADD.php';
	include '../Views/Reserva/Reserva_EDIT.php';
	include '../Views/Reserva/Reserva_SEARCH.php';
	include '../Views/Reserva/Reserva_DELETE.php';
	include '../Views/Reserva/Reserva_SHOWCURRENT.php';
	include '../Views/Reserva/Reserva_SHOWALL.php';
	include '../Views/Reserva/Reserva_RESERVAR.php';
	include '../Views/MESSAGE.php';
	
function get_data_form(){
	if(!isset($_REQUEST['Reserva'])){
		$_REQUEST['Reserva'] = 0;
	}
	$Reserva = $_REQUEST['Reserva'];
	$codigoPistayHorario = $_REQUEST['codigoPistayHorario'];
	if(!isset($_REQUEST['DNI_Deportista'])){
		$_REQUEST['DNI_Deportista'] = $_SESSION['DNI'];
	}
	$DNI_Deportista = $_REQUEST['DNI_Deportista'];

	$reserva = new Reserva($Reserva, $codigoPistayHorario, $DNI_Deportista);
 
	return $reserva;
}
	

if (!isset($_REQUEST['submit'])){ //si no viene del formulario, no existe array POST
	$_REQUEST['submit'] = 'SHOWALL';
}

//Control de acceso
if(!isAdmin()){
	if($_REQUEST['submit'] === 'SHOWALL'){
		$_REQUEST['submit'] = 'RESERVARALL';
	}else if($_REQUEST['submit'] != 'RESERVARONE' || $_REQUEST['submit'] != 'RESERVAR'){
		$_REQUEST['submit'] = 'RESERVARALL';
	}
}

switch ($_REQUEST['submit']){
	case 'RESERVARALL':
		if(!$_POST){//Si GET
			$pistasyHorariosDisponibles = new Pista('','');
			$pistasyHorariosDisponibles = $pistasyHorariosDisponibles->SHOWALL_AND_HORARIOS_LIBRES();
			if($pistasyHorariosDisponibles->num_rows == 0){
				new Mensaje('No quedan pistas libres', '../index.php');// y a ver qué ha pasado en la BD
			}else{
				$muestraReserva = new Reserva_RESERVAR($pistasyHorariosDisponibles);//Mostrar vista reservar
			}
		}else{
			$reserva = get_data_form();//Si post cogemos reserva
			$respuesta = $reserva->ADD();//Y lo añadimos
			new Mensaje($respuesta, '../Controllers/Controller_Reserva.php');// y a ver qué ha pasado en la BD
		}
		break;
		
	case 'RESERVARONE':
		if(!$_POST){//Si GET
			$HorariosDisponibles = new Pista($_REQUEST['codigoPista'],'');
			$HorariosDisponibles = $HorariosDisponibles->SHOWCURRENT_AND_HORARIO_LIBRE();
			$muestraReserva = new Reserva_RESERVAR($HorariosDisponibles);//Mostrar vista reservar
		}else{
			$reserva = get_data_form();//Si post cogemos reserva
			$respuesta = $reserva->ADD();//Y lo añadimos
			new Mensaje($respuesta, '../Controllers/Controller_Reserva.php');// y a ver qué ha pasado en la BD
		}
		break;
		
	case 'RESERVAR':
		if(!$_POST){//Si GET
			$pistasyHorariosDisponibles = new Pista('','');
			$pistasyHorariosDisponibles = $pistasyHorariosDisponibles->SHOWALL_AND_HORARIOS_LIBRES();
			var_dump($pistasyHorariosDisponibles);
			if($pistasyHorariosDisponibles->num_rows() == 0){
				new Mensaje('No quedan pistas libres', '../Controllers/Controller_Reserva.php');// y a ver qué ha pasado en la BD
			}else{
				$muestraReserva = new Reserva_RESERVAR($pistasyHorariosDisponibles);//Mostrar vista reservar
			}
		}else{
			$reserva = new Reserva('',$_REQUEST['codigoPistayHorario'], $_REQUEST['DNI_Deportista']);//Editar reserva seleccionado
			$respuesta = $reserva->ADD();//Y lo añadimos
			new Mensaje($respuesta, '../Controllers/Controller_Reserva.php');// y a ver qué ha pasado en la BD
		}
		break;
		
	case 'ADD':
		if(!$_POST){//Si GET
			$muestraADD = new Reserva_ADD();//Mostrar vista add
		}else{
			$reserva = get_data_form();//Si post cogemos reserva
			$respuesta = $reserva->ADD();//Y lo añadimos
			new Mensaje($respuesta, '../Controllers/Controller_Reserva.php');// y a ver qué ha pasado en la BD
		}
		break;
		
	case 'EDIT':
		if(!$_POST){//Si GET
			$reserva = new Reserva($_REQUEST['Reserva'],'', '');//Editar reserva seleccionado
			$reserva->_getDatosGuardados();//Rellenar con los datos de la BD
			new Reserva_EDIT($reserva);//Mostrar vista
		}else{
			$reserva = get_data_form();//Coger datos
			$respuesta = $reserva->EDIT();//Actualizarlos
			new Mensaje($respuesta, '../Controllers/Controller_Reserva.php');//A ver que pasa con la BD, qué intrigante
		}
		break;
		
	case 'SEARCH':
		if(!$_POST){//Si GET
			$muestraSEARCH = new Reserva_SEARCH();//Mostrar vista buscadora
		}else{
			$reserva = get_data_form();//Creamos un reserva con los datos introducidos (que no insertarlo en la BD)
			$respuesta = $reserva->SEARCH();//Buscamos los datos que se parezcan a los introducidos
			if(!is_string($respuesta)){
				new Reserva_SHOWALL($respuesta);
			}else{//sino
				new Mensaje($respuesta, '../Controllers/Controller_Pista.php');//Mensaje de error, que hay muchos
			}
		}
		break;
		
	case 'DELETE':
		if(!$_POST){//Si GET
			$reserva = new Reserva($_REQUEST['Reserva'],'', '');//Coger reserva guardado a eliminar
			$reserva->_getDatosGuardados();//Rellenar datos
			new Reserva_DELETE($reserva);//Mostrar vissta 
		}else{//Si confirma borrado llega por post
			$reserva = new Reserva($_POST['Reserva'],'','');//Clave
			$respuesta = $reserva->DELETE();//Borrar reserva con dicha clave
			new Mensaje($respuesta, '../Controllers/Controller_Reserva.php');//A ver qué pasa en la BD
		}
	break;
		
	case 'SHOWCURRENT':
		if(!$_POST){//Si GET
			$reserva = new Reserva($_REQUEST['Reserva'],'', '');//Coger clave del reserva
			$respuesta = $reserva->SHOWCURRENT();
			if(!is_string($respuesta)){//NO debería ser posible pedir un showcurrent de algo no existente pero si esp osible retornará un string, así que si no es un string es un reserva
				$reserva->_getDatosGuardados();
				new Reserva_SHOWCURRENT($reserva);//Mostrar al reserva rellenado
			}else{//sino
				new Mensaje($respuesta, '../Controllers/Controller_Reserva.php');//Mensaje de error, que hay muchos
			}
		}
		break;
		
	case 'SHOWALL':
		$reserva = new Reserva('','','');//No necesitamos reserva para buscar (pero sí para acceder a la BD)
		$respuesta = $reserva->SHOWALL();//Todos los datos de la BD estarán aqúi
		new Reserva_SHOWALL($respuesta, '');//Le pasamos todos los datos de la BD
		break;
		
	default:
		$reserva = new Reserva('','','');//No necesitamos reserva para buscar (pero sí para acceder a la BD)
		$respuesta = $reserva->SHOWALL();//Todos los datos de la BD estarán aqúi
		new Reserva_SHOWALL($respuesta, '');//Le pasamos todos los datos de la BD
		break;
}
?>