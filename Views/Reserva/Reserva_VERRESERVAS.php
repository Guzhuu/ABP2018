<?php
/* 
	Vista para mostrar las reservas de un usuaio
*/
	
class Reserva_VERRESERVAS extends Reserva_SHOWALL{  // declaracion de clase
	var $showCancelarReserva = true;

	function __construct($respuesta){
		$this->controlador = 'Controller_Reserva.php';
		$this->resultado = $respuesta;
		$this->showEdit = false;
		$this->showDelete = false;
		$this->showAdd = false;
		$this->showSearch = false;
		$this->showShowcurrent = false;
		$this->showCancelarReserva = true;
		$this->toString();
	} // fin del constructor
	
	
	function botonesOpcion(){
		if($this->showCancelarReserva){
			echo "<input class='btn btn-danger' type='submit' name='submit' value='CANCELARRESERVA'/>";
		}
	}

} 
?>