<?php
/* 
	Controller de clases
*/
	session_start();
	include_once '../Functions/Autenticacion.php';
	
	include '../Modelos/Clase.php';
	
	include '../Views/Clase/Clase_EDIT.php';
	include '../Views/Clase/Clase_SEARCH.php';
	include '../Views/Clase/Clase_DELETE.php';
	include '../Views/Clase/Clase_ANULARCLASE.php';
	include '../Views/Clase/Clase_ANULARCURSO.php';
	include '../Views/Clase/Clase_SHOWCURRENT.php';
	include '../Views/Clase/Clase_EDITHORARIO.php';
	include '../Views/Clase/Clase_ADD.php';
	include '../Views/Clase/Clase_SHOWALL.php';
	include '../Views/Clase/Clase_SHOWALLFROM.php';
	include '../Views/Clase/Clase_SHOWALLFOR.php';
	include '../Views/MESSAGE.php';
	
	
function get_data_form(){
	if(isset($_REQUEST['Clase'])){
		$Clase = $_REQUEST['Clase'];
	}else{
		$Clase = 0;
	}
	if(!isset($_REQUEST['Reserva_Reserva'])){
		$_REQUEST['Reserva_Reserva'] = null;
	}
	$Reserva = $_REQUEST['Reserva_Reserva'];
	$codigoEscuela = $_REQUEST['codigoEscuela'];
	if(!isAdmin()){
		$_REQUEST['Entrenador'] = $_SESSION['DNI'];
	}
	$Entrenador = $_REQUEST['Entrenador'];
	$Curso = $_REQUEST['Curso'];
	if($Curso === ''){
		$Curso = 'Ningún curso';
	}
	$Particulares = $_REQUEST['Particulares'];

	$clase = new Clase($Clase, $Reserva, $codigoEscuela, $Entrenador, $Curso, $Particulares);
 
	return $clase;
}
	

if (!isset($_REQUEST['submit'])){ //si no viene del formulario, no existe array POST
	if(isAdmin()){
		$_REQUEST['submit'] = 'SHOWALL';
	}else{
		$accionesPermitidasEntrenador = array("EDITHORARIO", "SHOWALLFROM", "ANULARCURSO", "ANULARCLASE", "VERALUMNOS", "MISCLASES", "APUNTARSE", "ABANDONAR");
		$accionesPermitidasUser = array("MISCLASES", "APUNTARSE", "ABANDONAR");
		if(isset($_SESSION['rolEntrenador']) && $_SESSION['rolEntrenador']){
			//Entrenador
			if(!isset($_REQUEST['submit']) || !in_array($_REQUEST['submit'], $accionesPermitidasEntrenador)){
				$_REQUEST['submit'] = 'SHOWALL';
			}
		}else{
			if(isset($_SESSION['DNI'])){
				//Usuario
				if(!isset($_REQUEST['submit']) || !in_array($_REQUEST['submit'], $accionesPermitidasUser)){
					$_REQUEST['submit'] = 'APUNTARSE';
				}
			}else{
				//Guest
				new Mensaje("Error de login", '../index.php');
			}
		}
	}
}

switch ($_REQUEST['submit']){
	case 'ADD':
		if(!$_POST){//Si GET
			include_once '../Modelos/Reserva.php';
			if(isAdmin()){
				$reserva = new Reserva('', '', '');
				$Reservas = $reserva->RESERVAS();
				include_once '../Modelos/Deportista.php';
				$aux = new Deportista('','','','','','','','','');
				$Entrenadores = $aux->ENTRENADORES();
			}else{
				$reserva = new Reserva('', '', $_SESSION['DNI']);
				$Reservas = $reserva->RESERVASDE();
				$Entrenadores = '';
			}
			$clase = new Clase('','','','','','');
			$Escuelas = $clase->ESCUELAS();
			$Cursos = $clase->CURSOS();
			$muestraADD = new Clase_ADD($Reservas, $Escuelas, $Cursos, $Entrenadores);//Mostrar vista add
		}else{
			$clase = get_data_form();//Si post cogemos clase
			if($clase->_getReserva() != null){
				$respuesta = $clase->ADD();//Y lo añadimos
				new Mensaje($respuesta, '../Controllers/Controller_Clase.php');// y a ver qué ha pasado en la BD
			}else{
				$respuesta = $clase->ADD();//Y lo añadimos
				new Mensaje("Haga una reserva", '../Controllers/Controller_Clase.php');// y a ver qué ha pasado en la BD
			}
		}
		break;
		
	case 'EDIT':
		if(!$_POST){//Si GET
			if(isAdmin()){
				include_once '../Modelos/Deportista.php';
				$aux = new Deportista('','','','','','','','','');
				$Entrenadores = $aux->ENTRENADORES();
			}else{
				$Entrenadores = '';
			}
			$clase = new Clase($_REQUEST['Clase'],'','','','','');
			$clase->_getDatosGuardados();
			$Escuelas = $clase->ESCUELAS();
			$Cursos = $clase->CURSOS();
			$muestraEDIT = new Clase_EDIT($clase, $Escuelas, $Cursos, $Entrenadores);//Mostrar vista add
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
			$clase = new Clase($_REQUEST['Clase'], '', '', '', '', '');//Coger clase guardado a eliminar
			$clase->_getDatosGuardados();//Rellenar datos
			new Clase_DELETE($clase);//Mostrar vissta 
		}else{//Si confirma borrado llega por post
			$clase = new Clase($_REQUEST['Clase'],'','','', '', '');//Clave
			$respuesta = $clase->DELETE();//Borrar clase con dicha clave
			new Mensaje($respuesta, '../Controllers/Controller_Clase.php');//A ver qué pasa en la BD
		}
	break;
		
	case 'ANULARCLASE':
		if(!$_POST){//Si GET
			$clase = new Clase($_REQUEST['Clase'], '', '', '', '', '');//Coger clase guardado a eliminar
			$clase->_getDatosGuardados();//Rellenar datos
			$respuesta = $clase->DETALLES();
			if(is_string($respuesta)){
				new Mensaje($respuesta, '../Controllers/Controller_Clase.php');//Mensaje de error, que hay muchos
			}else{
				new Clase_ANULARCLASE($respuesta);//Mostrar vissta 
			}
		}else{//Si confirma borrado llega por post
			$clase = new Clase($_REQUEST['Clase'], '', '', '', '', '');//Clave
			$clase->_getDatosGuardados();
			$respuesta = $clase->ANULARCLASE();//Borrar curso con dicha clave
			new Mensaje($respuesta, '../Controllers/Controller_Clase.php');//A ver qué pasa en la BD
		}
		break;
		
	case 'ANULARCURSO':
		if(!$_POST){//Si GET
			$clase = new Clase($_REQUEST['Clase'], '', '', '', '', '');//Coger clase guardado a eliminar
			$clase->_getDatosGuardados();//Rellenar datos
			$respuesta = $clase->CURSO();
			if(is_string($respuesta)){
				new Mensaje($respuesta, '../Controllers/Controller_Clase.php');//Mensaje de error, que hay muchos
			}else{
				new Clase_ANULARCURSO($respuesta);//Mostrar vissta 
			}
		}else{//Si confirma borrado llega por post
			$clase = new Clase($_REQUEST['Clase'], '', '', '', '', '');//Clave
			$clase->_getDatosGuardados();
			$respuesta = $clase->ANULARCURSO();//Borrar curso con dicha clave
			new Mensaje($respuesta, '../Controllers/Controller_Clase.php');//A ver qué pasa en la BD
		}
		break;
		
	case 'EDITHORARIO':
		if(!$_POST){//Si GET
			$clase = new Clase($_REQUEST['Clase'], '', '', '', '', '');//Coger clase guardado a eliminar
			$clase->_getDatosGuardados();//Rellenar datos
			$horarios = $clase->HORARIOSLIBRES();
			if(is_string($horarios)){
				new Mensaje($horarios, '../Controllers/Controller_Clase.php');//Mensaje de error, que hay muchos
			}else{
				new Clase_EDITHORARIO($horarios, $clase);//Mostrar vissta 
			}
		}else{//Si confirma borrado llega por post
			/**	Explicación:
				* En vez de borrar la reserva y hacer una nueva con la nueva pista y el nuevo horario, se edita la pista y horario de la reserva que ya tiene
				**/
			if(!isset($_REQUEST['codigoPistayHorario']) || !isset($_SESSION['DNI'])){
				new Mensaje("Error al seleccionar pista y horario", '../Controllers/Controller_Clase.php');//A ver qué pasa en la BD
			}else{
				$clase = new Clase($_REQUEST['Clase'],'','','','', '');//Clave
				$clase->_getDatosGuardados();
				if($_REQUEST['codigoPistayHorario'] != $clase->_getCodigoPistayHorario()){
					include_once '../Modelos/Reserva.php';
					$reserva = new Reserva($_REQUEST['Reserva_Reserva'], $_REQUEST['codigoPistayHorario'], $_SESSION['DNI']);
					$respuestaReserva = $reserva->EDIT();
					if($respuestaReserva == 'Modificado correcto'){
						$clase->_setReserva($_REQUEST['Reserva_Reserva']);
						
						$respuesta = $clase->EDIT();
						new Mensaje($respuesta, '../Controllers/Controller_Clase.php');//A ver qué pasa en la BD
					}else{
						new Mensaje("Error al crear nueva reserva", '../Controllers/Controller_Clase.php');//A ver qué pasa en la BD
					}
				}else{
					new Mensaje("No se ha seleccionado un nuevo horario", '../Controllers/Controller_Clase.php');//A ver qué pasa en la BD
				}
			}
		}
		break;
		
	case 'VERALUMNOS':
		if(!isset($_REQUEST['Clase'])){
			new Mensaje('Error al seleccionar la clase', '../Controllers/Controller_Clase.php');//A ver qué pasa en la BD
		}else{
			$clase = new Clase($_REQUEST['Clase'], '', '', '', '', '');//Clave
			$respuesta = $clase->ALUMNOS();
			if(is_string($respuesta)){
				new Mensaje($respuesta, '../Controllers/Controller_Clase.php');//A ver qué pasa en la BD
			}else{
				new Mensaje(var_dump($respuesta), '../Controllers/Controller_Clase.php');//A ver qué pasa en la BD
			}
		}
		break;
		
	case 'MISCLASES':
		$clase = new Clase('', '', '', '', '', '');//Clave
		$respuesta = $clase->CLASESDE($_SESSION['DNI']);
		if(is_string($respuesta)){
			new Mensaje($respuesta, '../Controllers/Controller_Clase.php');//A ver qué pasa en la BD
		}else{
			new Clase_SHOWALLFOR($respuesta, false);//A ver qué pasa en la BD
		}
		break;
		
	case 'APUNTARSE':
		if(!$_POST){//Si GET
			$clase = new Clase('', '', '', '', '', '');//Coger clase guardado a eliminar
			$respuesta = $clase->CLASESNOAPUNTADO($_SESSION['DNI']);//Rellenar datos
			if(is_string($respuesta)){
				new Mensaje($respuesta, '../Controllers/Controller_Clase.php');//Mensaje de error, que hay muchos
			}else{
				new Clase_SHOWALLFOR($respuesta, true);//Mostrar vissta 
			}
		}else{//Si confirma borrado llega por post
			$clase = new Clase($_REQUEST['codClase'], '', '', '', '', '');//Clave
			$respuesta = $clase->APUNTAR($_SESSION['DNI']);
			new Mensaje($respuesta, '../Controllers/Controller_Clase.php?submit=APUNTARSE');//A ver qué pasa en la BD
		}
		break;
		
	case 'ABANDONAR':
		$clase = new Clase($_REQUEST['Clase'], '', '', '', '', '');//Clave
		$respuesta = $clase->ABANDONAR($_SESSION['DNI']);
		new Mensaje($respuesta, '../Controllers/Controller_Clase.php?submit=MISCLASES');//A ver qué pasa en la BD
		break;
		
	case 'SHOWCURRENT':
		if(!$_POST){//Si GET
			$clase = new Clase($_REQUEST['Clase'],'','','', '', '');//Coger clave del clase
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
			$clase = new Clase('','','',$_SESSION['DNI'], '', '');//No necesitamos clase para buscar (pero sí para acceder a la BD)
			$respuesta = $clase->SHOWALLFROM();//Todos los datos de la BD que tenga su dni
			if(!is_string($respuesta)){
				new Clase_SHOWALLFROM($respuesta);//Le pasamos todos los datos de la BD
			}else{
				new Clase_SHOWALLFROM($respuesta);
			}
		}else{
			$clase = new Clase('','','','', '','');//No necesitamos clase para buscar (pero sí para acceder a la BD)
			$respuesta = $clase->SHOWALL();//Todos los datos de la BD estarán aqúi
			new Clase_SHOWALL($respuesta);//Le pasamos todos los datos de la BD
		}
		break;
	
		
	default:
		new Mensaje("Error", '../index.php');
		break;
}
?>