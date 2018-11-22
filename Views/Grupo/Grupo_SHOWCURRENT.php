<?php
/* 
	Vista para mostrar todos los Grupo
*/
include '../Views/base/SHOWCURRENT.php';
	
class Grupo_SHOWCURRENT extends SHOWCURRENT{  // declaracion de clase
	// declaracion constructor de la clase
	// se inicializa con los valores del formulario y el valor del botÃ³n submit pulsado
	function __construct($respuesta){
		$this->retorno = 'controller_Grupo.php';
		$this->resultado = (array) $respuesta;
		$this->toString();
	} // fin del constructor

} 
?>