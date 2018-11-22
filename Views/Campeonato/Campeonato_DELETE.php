<?php
/* 
	Vista para mostrar todos los campeonatos
*/
include '../Views/base/DELETE.php';
	
class Campeonato_DELETE extends DELETE{  // declaracion de clase
	// declaracion constructor de la clase
	// se inicializa con los valores del formulario y el valor del botÃ³n submit pulsado
	function __construct($respuesta){
		$this->controller = 'controller_Campeonato.php';
		$this->resultado = (array) $respuesta;
		$this->toString();
	} // fin del constructor

} 
?>