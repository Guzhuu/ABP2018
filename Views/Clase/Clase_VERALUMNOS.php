<?php
/* 
	Vista para ver alumnos de una clase
*/
	
class Clase_VERALUMNOS{
	var $controller;
	
	var $resultado;//Las tuplas a mostrar
	var $Alumnos = 'Alumnos';
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
		include '../Views/base/header.php';
		/**COMIENZO TABLA**/
		echo '<form method="POST" accept-charset="UTF-8" id="formularioAnularClase" name="formularioAnularClase" action="../Controllers/'; echo $this->controller; echo '">';
		echo '<table class="detalle">';
		$i = 0;
		echo '<tr class="'; echo $this->_getTr($i); echo'">';
		echo '<td class="formularioTd">';
			echo $this->Alumnos;
		echo '</td>';
			
		echo '<td class="formularioTd">';
		echo '<table class="table">';
			echo '<tr class="fila">';
				while($tituloColumna = $this->resultado->fetch_field()){
					if($tituloColumna->name != "DNI"){
						echo '<th class="tituloColumna">';
							echo $tituloColumna->name;
						echo '</th>';
					}
				}
			echo '</tr>';
		
			$num = 0;
			while($fila = $this->resultado->fetch_row()){
				/*Se crea una fila <tr>*/
				echo '<tr class="fila">';
				
				/*Se crean tantas celdas y se muestran sus datos como tenga la fila*/
				for($x = 0; $x < sizeof($fila); $x++){
					if($this->resultado->fetch_fields()[$x]->name != "DNI"){
						echo '<td class="celda">';
						echo $fila[$x];
						echo '</td>';
					}
				}
					
				echo '</tr>';
				$num++;
			}
			
		echo '</table>';
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