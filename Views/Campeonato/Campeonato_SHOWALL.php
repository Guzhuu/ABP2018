<?php
/* 
	Vista para mostrar todas los campeonatos
*/
include '../Views/base/SHOWALL.php';

class Campeonato_SHOWALL extends SHOWALL{  // declaracion de clase
	// declaracion constructor de la clase
	// se inicializa con los valores del formulario y el valor del botÃ³n submit pulsado
	var $showADDCATEGORIA = true;
	
	function __construct($respuesta){
		$this->controlador = 'Controller_Campeonato.php';
		$this->resultado = $respuesta;
		$this->toString();
	} // fin del constructor
	
	
	function botonesOpcion(){
		if($this->showADDCATEGORIA){
			echo "<input class='btn btn-secondary' type='submit' name='submit' value='ADDCATEGORIA'/>";
		}
	}
} 
 ?>