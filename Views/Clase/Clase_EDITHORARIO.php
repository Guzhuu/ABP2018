<?php
/* 
	Vista para anular una clase
*/
	
class Clase_EDITHORARIO{
	var $controller;
	
	var $horariosLibres;
	var $clase;	
	var $HorariosLibres = 'Horarios libres';
	var $Eliminar = 'Eliminar';
	var $Seleccionar = 'Seleccionar';
	var $Volver = 'Volver';
	
	function _getTr($i){
		if($i%2 == 0){
			return 'trPar';
		}else{
			return 'trImpar';
		}
	}
	
	function __construct($horariosLibres, $clase){
		$this->controller = 'Controller_Clase.php';
		$this->horariosLibres = $horariosLibres;
		$this->clase = $clase;
		$this->toString();
	} // fin del constructor
	
	function toString(){
		include '../Views/base/header.php';
		/**COMIENZO TABLA**/
		?>
		<script>
			function setHorario(x){
				document.getElementById("codigoPistayHorario").value = x;
			}
		</script>
		<?php
		echo '<form method="POST" accept-charset="UTF-8" id="formularioAnularClase" name="formularioAnularClase" action="../Controllers/'; echo $this->controller; echo '">';
		echo '<table class="detalle">';
		$i = 0;
		echo '<tr class="'; echo $this->_getTr($i); echo'">';
		echo '<td class="formularioTd">';
			echo $this->HorariosLibres;
		echo '</td>';
			
		echo '<td class="formularioTd">';
		echo '<table class="table">';
			echo '<tr class="fila">';
				while($tituloColumna = $this->horariosLibres->fetch_field()){
					echo '<th class="tituloColumna">';
						echo $tituloColumna->name;
					echo '</th>';
				}
				echo '<th class="tituloColumna">';
					echo $this->Seleccionar;
				echo '</th>';
			echo '</tr>';
		
			$num = 0;
			while($fila = $this->horariosLibres->fetch_row()){
				/*Se crea una fila <tr>*/
				echo '<tr class="fila">';
				
				/*Se crean tantas celdas y se muestran sus datos como tenga la fila*/
				for($x = 0; $x < sizeof($fila); $x++){
					echo '<td class="celda">';
					echo $fila[$x];
					echo '</td>';
				}
				echo '<td class="celda">';
				echo '<input class="btn btn-secondary" type="button" name="btnSeleccionar" onClick="setHorario('; echo $fila[0]; echo ');" value="'; echo $this->Seleccionar; echo '"/>';
				echo '</td>';
				
				echo '</tr>';
				$num++;
			}
			
		echo '</table>';
		echo '</td>';
		echo '</tr>';
		$i++;
		
		/*Fila para confirmar*/
		echo '<tr class="'; echo $this->_getTr($i); echo'">';
			echo '<td class="formularioTd">';
				echo $this->Eliminar;
			echo '</td>';
			
			echo '<td class="formularioTd">';
				echo '<input type="hidden" name="Clase" value="'; echo $this->clase->_getClase(); echo '"/>';
				echo '<input type="hidden" name="Reserva_Reserva" value="'; echo $this->clase->_getReserva(); echo '"/>';
				echo '<input type="hidden" id="codigoPistayHorario" name="codigoPistayHorario" value="'; echo $this->clase->_getCodigoPistayHorario(); echo '"/>';
				echo '<input class="btn btn-danger" type="submit" name="submit" value="EDITHORARIO"/>';
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