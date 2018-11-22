<?php
/*Vista genérica para mostrar una tupla. */
class SHOWCURRENT{
	//Lugar de retorno, hay que cambiarlo
	var $retorno;
	
	var $resultado;//Las tuplas a mostrar
	var $Volver = 'Volver';
	
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
					$i++;
				}
			}
			/*Fila para volver*/
			echo '<tr class="'; echo $this->_getTr($i); echo'">';
				echo '<td class="formularioTd">';
					echo $this->Volver;
				echo '</td>';
				
				echo '<td class="formularioTd">';
					echo '<a href="'; echo $this->retorno; echo '">';
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