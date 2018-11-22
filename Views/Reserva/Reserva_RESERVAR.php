<?php
/*Vista genérica para mostrar un array de pistas. */
class Reserva_RESERVAR{
	
	//Obligatorio ponerlo. Indica el controlador al que ir al hacer una petición
	var $controlador;
	
	var $campos;
	
	var $pistasyHorarios;
	
	function __construct($pistasyHorarios){
		$this->controlador = 'Controller_Reserva.php';
		$this->campos = array(
					"codigoPistayHorario" => "codigoPistayHorario",
					"nombre" => "nombre",
					"codigoPista" => "Pista_codigoPista",
					"codigoHorario" => "Horario_Horario",
					"HoraInicio" => "HoraInicio",
					"HoraFin" => "HoraFin",
					"DNI" => "DNI_Deportista");
		$this->pistasyHorarios = $pistasyHorarios;
		$this->toString();
	}
	
	// muestra por pantall html con los valores de los atributos de la clase
	// y un hiperenlace para volver al script php que la invoca
	function toString(){
		include '../Views/base/header.php';
		/**COMIENZO TABLA**/
			$i = 0;
			$fila = $this->pistasyHorarios->fetch_assoc();
			$prev = $fila[$this->campos['codigoPista']];
			echo '<form method="POST" accept-charset="UTF-8" id="reservar'; echo $i; echo '" name="reservar'; echo $i; echo'" action="../Controllers/'; echo $this->controlador; echo '">';
			$i++;
			echo '<table class="pistaPadel">';
			//Creamos la primera fila
			echo '<tr class="lineaPadel">';
				echo '<td class="pista">';
				echo '</td>';
			echo '</tr>';
				
			echo '<tr class="nombrePista">';
				echo '<td class="nombre">';
						echo '<input type="hidden" name="'; echo $this->campos['codigoPistayHorario']; echo '" value="'; echo $fila[$this->campos['codigoPistayHorario']]; echo '">';
					echo '</input>';
					echo $fila[$this->campos['nombre']];
				echo '</td>';
			echo '</tr>';
			//Añadimos boton para el horario
				echo '<tr class="horariosPadel">';
					echo '<td class="botonHorario">';
						echo '<br/><b class="lblBtReservar"> Desde las ' . $fila[$this->campos['HoraInicio']] . ' hasta las ' . $fila[$this->campos['HoraFin']] . '</b>';
						echo '<input type="submit" style="width:100%" value="RESERVAR">';
					echo '</td>';
					echo '</input>';
				echo '</tr>';
			
			while($fila = $this->pistasyHorarios->fetch_assoc()){
				//Si se acaban los horarios de una pista, comenzamos la tabla de la siguiente
				if($fila[$this->campos['codigoPista']] != $prev){
					$prev = $fila[$this->campos['codigoPista']];
					echo '</table>';
					echo '</form>';
					echo '<br/>';
					echo '<br/>';
					echo '<br/>';
					echo '<form>';
					echo '<table class="pistaPadel">';
					//Creamos la primera fila
					echo '<tr class="lineaPadel">';
						echo '<td class="pista">';
						echo '</td>';
					echo '</tr>';
						
					echo '<tr class="nombrePista">';
						echo '<td class="nombre">';
							echo '<input type="hidden" name="'; echo $this->campos['codigoPista']; echo '" value="'; echo $fila[$this->campos['codigoPista']]; echo '">';
							echo '</input>';
							echo $fila[$this->campos['nombre']];
						echo '</td>';
					echo '</tr>';
				}
				//Añadimos boton para el horario
				echo '<tr class="horariosPadel">';
					echo '<td class="botonHorario">';
						echo '<br/><b class="lblBtReservar"> Desde las ' . $fila[$this->campos['HoraInicio']] . ' hasta las ' . $fila[$this->campos['HoraFin']] . '</b>';
						echo '<input type="hidden" name="'; echo $this->campos['codigoHorario']; echo '" value="'; echo $fila[$this->campos['codigoHorario']]; echo '">';
						echo '<input type="submit" style="width:100%" value="RESERVAR">';
					echo '</td>';
					echo '</input>';
				echo '</tr>';
			}
			echo '</table>';
		/**FIN DE TABLA**/
		include '../Views/base/footer.php';
	}
}
?>