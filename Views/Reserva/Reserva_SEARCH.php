<?php
/* 
	Vista para buscar un reserva
*/
	
class Reserva_SEARCH{  // declaración de clase
	var $campos;
	var $controller;
	var $submit = 'SEARCH';

	// declaración constructor de la clase
	// se inicializa con los valores del formulario y el valor del botón submit pulsado
	function __construct(){
		$this->campos = array(
					"Reserva" => "Codigo de la reserva",
					"codigoPista" => "Codigo de la pista",
					"Horario" => "Codigo del horario",
					"codigoPistayHorario" => "Codigo de la pista y horario",
					"DNI_Deportista" => "DNI del usuario de la reserva");
		$this->controller = 'Controller_Reserva.php';
		$this->toString();
	} // fin del constructor
	
	function _getTr($i){
		if($i % 2){
			return "trImpar";
		}else{
			return "trPar";
		}
	}

	// declaración de método pinta()
	// muestra por pantall html con los valores de los atributos de la clase
	// y un hiperenlace para volver al script php que la invocó
	function toString(){
		include_once '../Views/base/header.php';
		
		$i = 0;
		/*Tabla para el formulario*/
		echo '<form method="POST" accept-charset="UTF-8" id="formularioSearch" name="formularioSearch" action="../Controllers/'; echo $this->controller; echo '">';
		echo '<table class="formulario">';
		
			/*Fila para codigo*/
			echo '<tr class="'; echo $this->_getTr($i); echo '">';
				echo '<td class="formularioTd">';
					echo $this->campos['Reserva'];
				echo '</td>';
				
				echo '<td class="formularioTd">';
					echo '<input type="text" name="Reserva" >';
					echo '</input>';
				echo '</td>';
			echo '</tr>';
			$i++;
			
			/*Fila para codigoPistayHorario*/
			echo '<tr class="'; echo $this->_getTr($i); echo '">';
				echo '<td class="formularioTd">';
					echo $this->campos['codigoPistayHorario'];
				echo '</td>';
				
				echo '<td class="formularioTd">';
					echo '<input type="text" name="codigoPistayHorario" >';
					echo '</input>';
				echo '</td>';
			echo '</tr>';
			$i++;
			
			/*Fila para DNI_Deportista*/
			echo '<tr class="'; echo $this->_getTr($i); echo '">';
				echo '<td class="formularioTd">';
					echo $this->campos['DNI_Deportista'];
				echo '</td>';
				
				echo '<td class="formularioTd">';
					echo '<input type="text" name="DNI_Deportista" >';
					echo '</input>';
				echo '</td>';
			echo '</tr>';
			$i++;
			
			/*Fila para submit*/
			echo '<tr class="'; echo $this->_getTr($i); echo '">';
				echo '<td class="formularioTd">';
					echo $this->submit;
				echo '</td>';
				
				echo '<td class="formularioTd">';
					echo '<input type="submit" name="submit" value="'; echo $this->submit; echo '">';
					echo '</input>';
				echo '</td>';
			echo '</tr>';
			$i++;
		echo '</table>';
		echo '</form>';
		include_once '../Views/base/footer.php';
	} // fin método pinta()
} //fin de class muestradatos
?>