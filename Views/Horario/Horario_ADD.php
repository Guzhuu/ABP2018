<?php
/* 
	Vista para añadir un Horario
*/
	
class Horario_ADD{  // declaración de clase
	var $campos;
	var $controller;
	var $submit = 'ADD';
	var $Volver = "Volver";

	// declaración constructor de la clase
	// se inicializa con los valores del formulario y el valor del botón submit pulsado
	function __construct(){
		$this->campos = array(
					"HoraInicio" => "Hora de inicio",
					"HoraFin" => "Hora de fin");
		$this->controller = 'Controller_Horario.php';
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
		echo '<form method="POST" accept-charset="UTF-8" id="formularioAdd" name="formularioAdd" action="../Controllers/'; echo $this->controller; echo '">';
		echo '<table class="formulario">';
		
			/*Fila para HoraInicio 2018-11-19 09:00:00*/
			echo '<tr class="'; echo $this->_getTr($i); echo'">';
				echo '<td class="formularioTd">';
					echo $this->campos['HoraInicio'];
				echo '</td>';
				
				echo '<td class="formularioTd">';
					echo '<input name="HoraInicio" type="datetime-local">';
					echo '</input>';
				echo '</td>';
			echo '</tr>';
			$i++;
			
			/*Fila para HoraFin 2018-11-19 09:00:00*/
			echo '<tr class="'; echo $this->_getTr($i); echo'">';
				echo '<td class="formularioTd">';
					echo $this->campos['HoraFin'];
				echo '</td>';
				
				echo '<td class="formularioTd">';
					echo '<input name="HoraFin" type="datetime-local">';
					echo '</input>';
				echo '</td>';
			echo '</tr>';
			$i++;
			
			/*Fila para submit*/
			echo '<tr class="'; echo $this->_getTr($i); echo'">';
				echo '<td class="formularioTd">';
					echo $this->submit;
				echo '</td>';
				
				echo '<td class="formularioTd">';
					echo '<input class="btn btn-success" type="submit" name="submit" value="'; echo $this->submit; echo '">';
					echo '</input>';
				echo '</td>';
			echo '</tr>';
			$i++;
			
			/*Fila para volver*/
			echo '<tr class="'; echo $this->_getTr($i); echo'">';
				echo '<td class="formularioTd">';
					echo $this->Volver;
				echo '</td>';
				
				echo '<td class="formularioTd">';
					echo '<a href="'; echo $this->controller; echo '">';
					echo '<button class="btn btn-secondary">'; echo $this->Volver; echo '</button>';
					echo '</a>';
				echo '</td>';
			echo '</tr>';
		echo '</table>';
		echo '</form>';
		include_once '../Views/base/footer.php';
	} // fin método pinta()
} //fin de class muestradatos
?>