<?php
/* 
	Vista para mostrar todas las pistas
*/
include '../Views/base/SHOWALL.php';

class Clase_SHOWALL extends SHOWALL{  // declaracion de clase
	// declaracion constructor de la clase
	// se inicializa con los valores del formulario y el valor del botÃ³n submit pulsado
	var $showAnularCurso = true;
	var $showEditHorario = true; //Editar clase
	var $showAnular = true; //Anular
	var $showVerAlumnos = true;
	
	function __construct($respuesta){
		$this->controlador = 'Controller_Clase.php';
		$this->resultado = $respuesta;
		$this->toString();
	} // fin del constructor
	
	function botonesOpcion(){
		if($this->showEditHorario){
			echo "<input class='btn btn-secondary' type='submit' name='submit' value='EDITHORARIO'/>";
		}
		if($this->showVerAlumnos){
			echo "<input class='btn btn-secondary' type='submit' name='submit' value='VERALUMNOS'/>";
		}
		if($this->showAnular){
			echo "<input class='btn btn-danger' type='submit' name='submit' value='ANULARCLASE'/>";
		}
		if($this->showAnularCurso){
			echo "<input class='btn btn-danger' type='submit' name='submit' value='ANULARCURSO'/>";
		}
	}
} 
 ?>