<?php
/*Vista genérica para mostrar una reserva antes de cancelarla */
class Reserva_CANCELARRESERVA{
	//Controller al que hay que mandar la petición
	var $controller;
	
	var $resultado;//Las tuplas a mostrar
	var $Cancelar = 'Cancelar';
	var $Volver = 'Volver';
	
	function __construct($respuesta){
		$this->controller = 'Controller_Reserva.php';
		$this->resultado = (array) $respuesta;
		$this->toString();
	} // fin del constructor
	
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
		/**COMIENZO TABLA**/
		echo '<form method="POST" accept-charset="UTF-8" id="formularioDelete" name="formularioDelete" action="../Controllers/'; echo $this->controller; echo '">';
		echo '<table class="detalle">';
			$i = 0;
			foreach ($this->resultado as $clave => $valor) {
				if($clave != 'mysqli'){
					echo '<tr class="'; echo $this->_getTr($i); echo'">';
						echo '<td class="formularioTd">';
							echo $clave;
						//echo '<td>';
						
						echo '<td class="mensaje">';
							echo $valor;
						//echo '<td>';
					echo '</tr>';
					echo '<input type="hidden" name="'; echo $clave; echo '" value="'; echo $valor; echo '"/>';
					$i++;
				}
			}
			/*Fila para Eliminar*/
			echo '<tr class="'; echo $this->_getTr($i); echo'">';
				echo '<td class="formularioTd">';
					echo $this->Cancelar;
				echo '</td>';
				
				echo '<td class="formularioTd">';
					echo '<input class="btn btn-danger" type="submit" name="submit" value="CANCELARRESERVA"/>';
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
			$i++;
			
		/**FIN TABLA**/
		echo '</table>';
		echo '</form>';
		include '../Views/base/footer.php';
	}
}
?>