<?php
/*Vista para añdir un horario a una pista */
class Pista_ADDHORARIO{
	
	//Obligatorio ponerlo. Indica el controlador al que ir al hacer una petición
	var $controlador;
	
	var $campos;
	
	var $pistasyHorarios;
	
	var $Volver = 'Volver';
	
	function __construct($pistasyHorarios){
		$this->controlador = 'Controller_Pista.php';
		$this->campos = array(
					"codigoPista" => "Codigo de pista",
					"codigoHorario" => "Horarios",
					"nombre" => "Nombre de la pista",
					"HoraInicio" => "HoraInicio",
					"HoraFin" => "HoraFin");
		$this->pistasyHorarios = $pistasyHorarios;
		$this->toString();
	}
	
	function _getTr($i){
		if($i%2 == 0){
			return 'trPar';
		}else{
			return 'trImpar';
		}
	}
	
	// muestra por pantall html con los valores de los atributos de la clase
	// y un hiperenlace para volver al script php que la invoca
	function toString(){
		include '../Views/base/header.php';
		
		echo '<table class="detalle">';
			$i = 0;
			while($fila = $this->pistasyHorarios->fetch_row()){
				if($i == 0){
					echo '<tr class="'; echo $this->_getTr($i); echo'">';
						echo '<td class="formularioTd">';
							echo $this->campos['nombre'];
						echo '</td>';
						
						echo '<td class="nombrePista">';
							echo $fila[1];
						echo '</td>';
					echo '</tr>';
					$i++;
					echo '<tr class="'; echo $this->_getTr($i); echo'">';
						echo '<td class="formularioTd">';
							echo $this->campos['codigoHorario'];
						echo '</td>';
					echo '<td class="mensaje">';
				}
				echo '<form method="POST" accept-charset="UTF-8" id="addHorario'; echo $i; echo '" name="addHorario'; echo $i; echo '" action="../Controllers/'; echo $this->controlador; echo '">';
				echo '<b class="lblBtAddHorario"> Desde las ' . $fila[3] . ' hasta las ' . $fila[4] . '</b>';
				echo '<input type="hidden" name="codigoPista" value="'; echo $fila[0]; echo '"/>';
				echo '<input type="hidden" name="codigoHorario" value="'; echo $fila[2]; echo '"/>';
				echo '<input type="hidden" name="nombre" value="'; echo $fila[1]; echo '"/>';
				echo '<input class="btn btn-info" type="submit" name="submit" value="ADDHORARIO"/><br/><br/>';
				echo '</form>';
			}
			echo '</td>';
			echo '</tr>';
				$i++;
			/*Fila para volver*/
			echo '<tr class="'; echo $this->_getTr($i); echo'">';
				echo '<td class="formularioTd">';
					echo $this->Volver;
				echo '</td>';
				
				echo '<td class="formularioTd">';
					echo '<a href="'; echo $this->controlador; echo '">';
					echo '<button class="btn btn-secondary">'; echo $this->Volver; echo '</button>';
					echo '</a>';
				echo '</td>';
			echo '</tr>';
			
		/**FIN TABLA**/
		echo '</table>';
		include '../Views/base/footer.php';
	}
}
?>