<?php
/* 
	Vista para mostrar todos los Grupo
*/
include '../Views/base/SHOWALL.php';
	
class GRUPO_SHOWALL extends SHOWALL{  // declaracion de clase
	// declaracion constructor de la clase
	// se inicializa con los valores del formulario y el valor del botÃ³n submit pulsado

	var $showADDCALENDARIO = true;

	function __construct($respuesta){
		$this->controlador = 'Controller_Grupo.php';
		$this->resultado = $respuesta;
		$this->toString();
	} // fin del constructor
function botonesOpcion(){
		//Implementar, si es necesario, en las vistas_SHOWALL.php 
		// a poder ser acordaos de poenrlo btn-secondary en vez de btn-primary
		/*************************** EJEMPLO ************************/
			if($this->showADDCALENDARIO){
				echo "<input class='btn btn-secondary' type='submit' name='submit' value=' GENERAR CALENDARIO'/>";
			}
		//*************************************************************/
	}

} 
?>