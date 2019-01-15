<?php
/* 
	Controller del campeonato
*/
	session_start();
	include_once '../Functions/Autenticacion.php';
	if(autenticado()){
		if(!isAdmin()){
			if(isset($_REQUEST['submit'])){
				if($_REQUEST['submit']!='ESCOGERPAREJA' && $_REQUEST['submit']!='SHOWALLFORUSER'){
					$_REQUEST['submit'] = 'SHOWALLFORUSER';
				}
			}
		}
	}
	else{
		header('Location: ../index.php');
	}

	
	include '../Modelos/Campeonato.php';
	include '../Modelos/Pareja_pertenece_categoria.php';
	include '../Modelos/Pareja_pertenece_categoria_de_campeonato.php';
	include '../Modelos/Campeonato_consta_de_categorias.php';
	include '../Views/Campeonato/Campeonato_ADD.php';
	include '../Views/Campeonato/Campeonato_EDIT.php';
	include '../Views/Campeonato/Campeonato_SEARCH.php';
	include '../Views/Campeonato/Campeonato_DELETE.php';
	include '../Views/Campeonato/Campeonato_SHOWCURRENT.php';
	include '../Views/Campeonato/Campeonato_SHOWALL.php';
	include '../Views/Campeonato/Campeonato_ADDCATEGORIA.php';
	include '../Views/Campeonato/Campeonato_ESCOGERPAREJA.php';
	include '../Views/Campeonato/Campeonato_SHOWPARAINSCRIBIRSE.php';
	include '../Views/Campeonato/Campeonato_SHOWALLFORUSER.php';
	include '../Modelos/Pareja.php';
	include '../Modelos/Deportista.php';
	include '../Modelos/Categoria.php';
	include '../Views/Campeonato/Campeonato_CLASIFICACION.php';

	include '../Views/Campeonato/Campeonato_INSCRITOS.php';

	include '../Views/Campeonato/Campeonato_CLASIFICACIONFINAL.php';

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
	if(!isset($_REQUEST['Nivel'])){
		$_REQUEST['Nivel'] = 0;
	}/*
	if(!isset($_REQUEST['codigoCategoria'])){
		$_REQUEST['Categoria'] = 0;
	}*/
	$codigoCategoria= $_REQUEST['codigoCategoria'];
	$DNICompanhero = $_REQUEST['DNI_Companhero'];
	$Nivel=$_REQUEST['Nivel'];
	$pareja = new Pareja('',$_SESSION['DNI'], $DNICompanhero);
	$_REQUEST['codPareja'] = $pareja->codPareja;
	$respuesta= $pareja->ADD();
	$capitan= new Deportista($_SESSION['DNI'],'', '', '', '', '', '', '', '');
	$capitan->_getDatosGuardados();
	$companhero= new Deportista($_REQUEST['DNI_Companhero'],'', '', '', '', '', '', '', '');
	$companhero->_getDatosGuardados();
	if($companhero->_getDatosGuardados()=='No existe el deportista'){
		new Mensaje('Por favor, introduzca un DNI de compañero que ya esté registrado en la plataforma.', '../Controllers/Controller_Campeonato.php?submit=ESCOGERPAREJA');
		return NULL;
	}
	else if($companhero->_getDatosGuardados()=='Deportista vacio, introduzca un deportista'){
		new Mensaje('Por favor, introduzca un DNI de compañero.', '../Controllers/Controller_Campeonato.php?submit=ESCOGERPAREJA');
		return NULL;		
	}
	else{
		$SexoPareja= determinarSexoCategoriaPareja($capitan,$companhero);	
		$catego= new Categoria($codigoCategoria,'','');
		$catego->_getDatosGuardados();
		//var_dump($catego);
		/*if($_REQUEST['DNI_Companhero']==0){
		new Mensaje('Por favor, introduzca un DNI de compañero válido.', '../Controllers/Controller_Campeonato.php?submit=ESCOGERPAREJA');
		return NULL;
	}*/
		if($SexoPareja!=$catego->Sexo){
			new Mensaje('El sexo de la categoría no es compatible con la pareja indicada. Por favor, introduzca un nivel en el cual el sexo sea compatible.', '../Controllers/Controller_Campeonato.php?submit=ESCOGERPAREJA');
			//$_REQUEST['submit']="ESCOGERPAREJA";
			return NULL;
		}
		else{
			$parejaPerteneceCategoria= new Pareja_pertenece_categoria('',$pareja->codPareja,$catego->Categoria);
 			//var_dump($parejaPerteneceCategoria);
 			return $parejaPerteneceCategoria; 		/*$parejaPerteneceCategoria->_getCodigo($parejaPerteneceCategoria->Pareja_codPareja,$parejaPerteneceCategoria->Categoria_Categoria);*/
 		}
		
	}
}

function determinarSexoCategoriaPareja(Deportista $capitan, Deportista $companhero){
	if($capitan->Sexo==$companhero->Sexo){
		if($capitan->Sexo=="Hombre"){
			return "M";
		}
		else{
			return "F";
		}
	}
	else if($capitan->Sexo!=$companhero->Sexo){
		return "MX";
	}
	else{
		return "Error";
	}
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
		if(!isset($_REQUEST['Campeonato'])){
			new Mensaje('No está indicado el campeonato', '../Controllers/Controller_Campeonato.php');// y a ver qué ha pasado en la BD
		}else{
			$campeonato = new Campeonato($_REQUEST['Campeonato'],'','','');//Si post cogemos Pista
			$respuesta = $campeonato->RANKINGFINAL();//Y lo añadimos
			if(is_string($respuesta)){
				new Mensaje($respuesta, '../Controllers/Controller_Campeonato.php');// y a ver qué ha pasado en la BD
			}else{
				new Campeonato_CLASIFICACIONFINAL($respuesta, '../Controllers/Controller_Campeonato.php');// y a ver qué ha pasado en la BD
			}
		}
		break;

	case 'ESCOGERPAREJA':
		if(!$_POST){//Si GET
			$Campeonato = new Campeonato('','','','');
			$Categorias=$Campeonato->CATEGORIAS();
			$muestraESCOGERPAREJA = new Campeonato_ESCOGERPAREJA($Categorias);//Mostrar vista add
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


	case 'INSCRIBIRSECATEGORIA':
		if(!isset($_REQUEST['Categoria'])){
			new Mensaje('No está indicada la categoría', '../Controllers/Controller_Campeonato.php');// y a ver qué ha pasado en la BD
		}
		else{
			if(!isset($_REQUEST['Campeonato'])){
				new Mensaje('No está indicado el campeonato', '../Controllers/Controller_Campeonato.php');// y a ver qué ha pasado en la BD
			}
			else{
				if(!isset($_REQUEST['codPareja'])){
				new Mensaje('No está indicado la pareja de esa categoria', '../Controllers/Controller_Campeonato.php');// y a ver qué ha pasado en la BD
			}
				else{
					$campeonato = new Campeonato($_REQUEST['Campeonato'],'','','');//Si post cogemos Pista
					$campeonato->_getDatosGuardados();
					/*
					$categoria= new Categoria($_REQUEST['Categoria'],'','');
					$categoria->_getDatosGuardados();
					$pareja= new Pareja($_REQUEST['codPareja'],'','');
					$pareja->_getDatosGuardados();*/
					$parejaPerteneceCategoria= new Pareja_pertenece_categoria($_REQUEST['perteneceCategoria'],$_REQUEST['codPareja'],$_REQUEST['Categoria']);
					//$parejaPerteneceCategoria->_getCodigo($parejaPerteneceCategoria->Pareja_codPareja,$parejaPerteneceCategoria->Categoria_Categoria);
					//var_dump($parejaPerteneceCategoria);
					$campeonatoConstaCategoria= new Campeonato_consta_de_categorias('',$_REQUEST['Campeonato'],$_REQUEST['Categoria']);
					$campeonatoConstaCategoria->_getCodigo($campeonatoConstaCategoria->Campeonato_Campeonato,$campeonatoConstaCategoria->Categoria_Categoria);
					$parejaPerteneceCategoriaCampeonato= new Pareja_pertenece_categoria_de_campeonato('',$campeonatoConstaCategoria->constadeCategorias,$parejaPerteneceCategoria->perteneceCategoria);
					$respuesta = $campeonato->INSCRIBIRPAREJAENCATEGORIADECAMPEONATO($parejaPerteneceCategoriaCampeonato);//Y lo añadimos
					/*new Mensaje($respuesta, '../Controllers/Controller_Campeonato.php');// y a ver qué ha pasado en la BD*/

					$parejaPerteneceCategoriaCampeonato->_getCodigo($parejaPerteneceCategoriaCampeonato->CampeonatoConstaCategoria,$parejaPerteneceCategoriaCampeonato->ParejaPerteneceCategoria);
					new Campeonato_INSCRITOS($respuesta, $parejaPerteneceCategoriaCampeonato,'','','','');
				}
				
			}
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
	case 'SHOWALLFORUSER':
		$Campeonato = new Campeonato('','','','');//No necesitamos Campeonato para buscar (pero sí para acceder a la BD)
		$respuesta = $Campeonato->SHOWALL();//Todos los datos de la BD estarán aqúi
		new Campeonato_SHOWALLFORUSER($respuesta, '','','','');//Le pasamos todos los datos de la BD
		break;
	default:
		new Mensaje("Error", '../index.php');// y a ver qué ha pasado en la BD
		break;
}
?>