<?php
/* 
	Vista para mostrar todos los Categoria
*/
include '../Views/base/DELETE.php';
	
class Categoria_DELETE extends DELETE{  // declaracion de clase
	// declaracion constructor de la clase
	// se inicializa con los valores del formulario y el valor del botÃ³n submit pulsado
	function __construct($respuesta){
		$this->controller = 'Controller_Categoria.php';
		$this->resultado = (array) $respuesta;
		$this->toString();
	} // fin del constructor

} 
?>