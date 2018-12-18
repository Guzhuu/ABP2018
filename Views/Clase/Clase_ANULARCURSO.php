<?php
/* 
	Vista para anular un curso
*/
	
class Clase_ANULARCURSO{  // declaracion de clase
	// declaracion constructor de la clase
	// se inicializa con los valores del formulario y el valor del botÃ³n submit pulsado
	var $controller;
	
	var $resultado;//Las tuplas a mostrar
	var $Eliminar = 'Eliminar';
	var $Volver = 'Volver';
	
	function _getTr($i){
		if($i%2 == 0){
			return 'trPar';
		}else{
			return 'trImpar';
		}
	}
	
	function __construct($respuesta){
		$this->controller = 'Controller_Clase.php';
		$this->resultado = $respuesta;
		$this->toString();
	} // fin del constructor
	
	function toString(){
		while($fila = $this->resultado->fetch_row()){
			var_dump($this->resultado->fetch_row());
		}
	}

} 
?>