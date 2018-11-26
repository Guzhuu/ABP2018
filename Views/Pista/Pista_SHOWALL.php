<?php
/* 
	Vista para mostrar todas las pistas
*/
include '../Views/base/SHOWALL.php';

class Pista_SHOWALL extends SHOWALL{  // declaracion de clase
	// declaracion constructor de la clase
	// se inicializa con los valores del formulario y el valor del botÃ³n submit pulsado
	var $showAddhorario = true;
	
	function __construct($respuesta){
		$this->controlador = 'Controller_Pista.php';
		$this->resultado = $respuesta;
		$this->toString();
	} // fin del constructor
	
	
	function botonesOpcion(){
		if($this->showAddhorario){
			echo "<input class='btn btn-secondary' type='submit' name='submit' value='ADDHORARIO'/>";
		}
	}
} 
 ?>