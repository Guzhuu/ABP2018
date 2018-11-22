<?php
/* 
	Vista para mostrar todas las pistas
*/
include '../Views/base/SHOWALL.php';

class Partido_SHOWALL extends SHOWALL{  // declaracion de clase
	
var $showEdit = false;
	// declaracion constructor de la clase
	// se inicializa con los valores del formulario y el valor del botÃ³n submit pulsado
	function __construct($respuesta){
		$this->controlador = 'Controller_Partido.php';
		$this->resultado = $respuesta;
		$this->toString();
	} // fin del constructor

} 
 ?>