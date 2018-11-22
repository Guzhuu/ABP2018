<?php
/* 
	Vista para mostrar todos los Grupo
*/
include '../Views/base/SHOWALL.php';
	
class GRUPO_SHOWALL extends SHOWALL{  // declaracion de clase
	// declaracion constructor de la clase
	// se inicializa con los valores del formulario y el valor del botÃ³n submit pulsado
	function __construct($respuesta){
		$this->controlador = 'Controller_Grupo.php';
		$this->resultado = $respuesta;
		$this->toString();
	} // fin del constructor

} 
?>