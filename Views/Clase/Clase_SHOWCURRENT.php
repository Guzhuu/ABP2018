<?php
/* 
	Vista para mostrar todos las clases
*/
include '../Views/base/SHOWCURRENT.php';
	
class Clase_SHOWCURRENT extends SHOWCURRENT{  // declaracion de clase
	// declaracion constructor de la clase
	// se inicializa con los valores del formulario y el valor del botÃ³n submit pulsado
	function __construct($respuesta){
		$this->retorno = 'Controller_Clase.php';
		$this->resultado = (array) $respuesta;
		$this->toString();
	} // fin del constructor

} 
?>