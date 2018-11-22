<?php
/* 
	Vista para añadir un pista
*/
	
class Partido_ADD{  // declaración de clase
	var $partido;
	var $campos;
	var $controller;
	var $submit = 'ADD';
	var $pistasHorariosLibres;

	// declaración constructor de la clase
	// se inicializa con los valores del formulario y el valor del botón submit pulsado
	function __construct($pistasyHorariosLibres){
		$this->campos = array("codigoPistayHorario"=> "Codigo de la Pista/Horario","codigoPista" => "Codigo de la Pista",
			"codigoHorario"=> "Codigo del Horario", "nombre" => "Nombre de la pista",
					"HoraInicio" => "Fecha de Inicio",
					"HoraFin" => "Fecha de Fin");
		$this->pistasHorariosLibres=$pistasyHorariosLibres;
		$this->controller = 'Controller_Partido.php';
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
		while ($fila=$this->pistasHorariosLibres->fetch_assoc()){
		/*Tabla para el formulario*/
			echo '<form method="POST" accept-charset="UTF-8" id="formularioAdd" name="formularioAdd" action="../Controllers/'; echo $this->controller; echo '">';
			echo '<table class="formulario">';
		
			/*Fila para nombre*/
				echo '<tr class="'; echo $this->_getTr($i); echo '">';
					echo '<td class="formularioTd">';
						echo $this->campos['codigoPistayHorario'];
					echo '</td>';
				
					echo '<td class="formularioTd">';
						echo $fila["codigoPistayHorario"];
					echo '</td>';

					
				echo '</tr>';
				$i++;
			
				echo '<tr class="'; echo $this->_getTr($i); echo '">';
					echo '<td class="formularioTd">';
						echo $this->campos['codigoPista'];
					echo '</td>';
				echo '<input type="hidden" name="codigoPista" value="'; echo $fila["Pista_codigoPista"]; echo '">';
					echo '<td class="formularioTd">';
						echo $fila["Pista_codigoPista"];
					echo '</td>';
				echo '</tr>';
				$i++;
			
				echo '<tr class="'; echo $this->_getTr($i); echo '">';
					echo '<td class="formularioTd">';
						echo $this->campos['codigoHorario'];
					echo '</td>';
				
				echo '<input type="hidden" name="codigoHorario" value="'; echo $fila["Horario_Horario"]; echo '">';
					echo '<td class="formularioTd">';
						echo $fila["Horario_Horario"];
					echo '</td>';
				echo '</tr>';
				$i++;

				echo '<tr class="'; echo $this->_getTr($i); echo '">';
					echo '<td class="formularioTd">';
						echo $this->campos['HoraInicio'];
					echo '</td>';
				
					echo '<td class="formularioTd">';
						echo $fila["HoraInicio"];
					echo '</td>';
				echo '</tr>';
				$i++;

					echo '<tr class="'; echo $this->_getTr($i); echo '">';
					echo '<td class="formularioTd">';
						echo $this->campos['HoraFin'];
					echo '</td>';
				
					echo '<td class="formularioTd">';
						echo $fila["HoraFin"];
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
	}
		include_once '../Views/base/footer.php';
		
	} // fin método pinta()
} //fin de class muestradatos
?>