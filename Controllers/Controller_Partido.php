<?php
/* Controller del ACCION y las horarioes que se le podrán realizar
	por 3hh731, kch3f4, j7g9n1, ymh5sa, hgdnog 
	28/11/17
*/
	session_start();
	include_once '../Functions/Autenticacion.php';
	if(!autenticado()){
		header('Location: ../index.php');
	}
	include '../Functions/ConectarBD.php';
	include '../Modelos/Partido.php';
	include '../Modelos/Pista.php';
	include '../Modelos/Horario.php';
	include '../Modelos/pista_tiene_horario.php';
	include '../Views/Partido/Partido_ADD.php';
	include '../Views/Partido/Partido_EDIT.php';
	include '../Views/Partido/Partido_SEARCH.php';
	include '../Views/Partido/Partido_DELETE.php';
	include '../Views/Partido/Partido_SHOWCURRENT.php';
	include '../Views/Partido/Partido_SHOWALL.php';
	include '../Views/MESSAGE.php';
	
function get_data_form(){
if (!isset($_REQUEST['Partido'])){ //si no viene del formulario, no existe array POST
	$_REQUEST['Partido'] = 0;
}
/*if (!isset($_REQUEST['codigoHorario'])){ //si no viene del formulario, no existe array POST
	$_REQUEST['codigoHorario'] = 0;
}
if (!isset($_REQUEST['codigoPista'])){ //si no viene del formulario, no existe array POST
	$_REQUEST['codigoPista'] = 0;
}*/
	$Partido = $_REQUEST['Partido'];
	$codigoHorario = $_REQUEST['codigoHorario'];
	$codigoPista = $_REQUEST['codigoPista'];

	$partidoo = new Partido($Partido, $codigoHorario, $codigoPista);
 
	return $partidoo;
}
	

if (!isset($_REQUEST['submit'])){ //si no viene del formulario, no existe array POST
	$_REQUEST['submit'] = 'SHOWALL';
}


switch ($_REQUEST['submit']){
	case 'ADD':
		if(!$_POST){//Si GET
			$pistasyhorariosDisponibles = new Pista('','');
			$pistasyhorariosDisponibles = $pistasyhorariosDisponibles->SHOWALL_AND_HORARIOS_LIBRES();
			$muestraADD = new Partido_ADD($pistasyhorariosDisponibles);//Mostrar vista add
		}else{

			$partido = get_data_form();//Si post cogemos partido
			$respuesta = $partido->ADD();//Y lo añadimos
			new Mensaje($respuesta, '../Controllers/Controller_Partido.php');// y a ver qué ha pasado en la BD
		}
		break;
		
	case 'EDIT':
		if(!$_POST){//Si GET
			$partido = new Partido($_REQUEST['Partido'],'', '');//Editar partido seleccionado
			$partido->_getDatosGuardados();//Rellenar con los datos de la BD
			new Partido_EDIT($partido);//Mostrar vista
		}else{
			$partido = get_data_form();//Coger datos
			$respuesta = $partido->EDIT();//Actualizarlos
			new Mensaje($respuesta, '../Controllers/Controller_Partido.php');//A ver que pasa con la BD, qué intrigante
		}
		break;
		
	case 'SEARCH':
		if(!$_POST){//Si GET
			$muestraSEARCH = new Partido_SEARCH();//Mostrar vista buscadora
		}else{
			$partido = get_data_form();//Creamos un partido con los datos introducidos (que no insertarlo en la BD)
			$respuesta = $partido->SEARCH();//Buscamos los datos que se parezcan a los introducidos
			new Partido_SHOWALL($respuesta, '');//Mostramos todos los datos recuperados de la BD (showall muestra todos los datos que se le pasan)
		}
		break;
		
	case 'DELETE':
		if(!$_POST){//Si GET
			$partido = new Partido($_REQUEST['Partido'],'', '');//Coger partido guardado a eliminar
			$partido->_getDatosGuardados();//Rellenar datos
			new Partido_DELETE($partido);//Mostrar vissta 
		}else{//Si confirma borrado llega por post
			$partido = new Partido($_POST['Partido'],'','');//Clave
			$respuesta = $partido->DELETE();//Borrar partido con dicha clave
			new Mensaje($respuesta, '../Controllers/Controller_Partido.php');//A ver qué pasa en la BD
		}
	break;
		
	case 'SHOWCURRENT':
		if(!$_POST){//Si GET
			$partido = new Partido($_REQUEST['Partido'],'', '');//Coger clave del partido
			$respuesta = $partido->SHOWCURRENT();
			if(!is_string($respuesta)){//NO debería ser posible pedir un showcurrent de algo no existente pero si esp osible retornará un string, así que si no es un string es un partido
				$partido->_getDatosGuardados();
				new Partido_SHOWCURRENT($partido);//Mostrar al partido rellenado
			}else{//sino
				new Mensaje($respuesta, '../Controllers/Controller_Partido.php');//Mensaje de error, que hay muchos
			}
		}
		break;
		
	case 'SHOWALL':
		$partido = new Partido('','','');//No necesitamos partido para buscar (pero sí para acceder a la BD)
		$respuesta = $partido->SHOWALL();//Todos los datos de la BD estarán aqúi
		new Partido_SHOWALL($respuesta, '');//Le pasamos todos los datos de la BD
		break;
		
	default:
		$partido = new Partido('','','');//No necesitamos partido para buscar (pero sí para acceder a la BD)
		$respuesta = $partido->SHOWALL();//Todos los datos de la BD estarán aqúi
		new Partido_SHOWALL($respuesta, '');//Le pasamos todos los datos de la BD
		break;
}
?>