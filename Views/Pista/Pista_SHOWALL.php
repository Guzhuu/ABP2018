<?php
/* 
	Vista para mostrar todas las pistas
*/
include '../Views/base/SHOWALL.php';

class Pista_SHOWALL extends SHOWALL{  // declaracion de clase
	// declaracion constructor de la clase
	// se inicializa con los valores del formulario y el valor del botÃ³n submit pulsado
	var $ADDHORARIO = true;
	
	function __construct($respuesta){
		$this->controlador = 'Controller_Pista.php';
		$this->resultado = $respuesta;
		$this->toString();
	} // fin del constructor
	
	function toString(){
		include '../Views/base/header.php';
		/**COMIENZO TABLA**/
		echo '<table>';
			echo "<form id='AnadirBuscar' method='GET' action='"; echo $this->controlador; echo "'>";
			echo '<tr class="filaInvisible">';
				echo '<td class="celdaInvisible">';
				echo "<input class='btn btn-success' type='submit' name='submit' value='ADD'/>";
				echo '</td>';
				
				echo '<td class="celdaInvisible">';
				echo "<input class='btn btn-primary' type='submit' name='submit' value='SEARCH'/>";
				echo '</td>';
			echo '</tr>';
			echo '</form>';
		echo '</table>';
			/**COMIENZO FILA TITULOS COLUMNA**/
		echo '<table class="table">';
			echo '<tr class="fila">';
				/*Para cada field (campo) se muestra su nombre*/
				while($tituloColumna = $this->resultado->fetch_field()){
					echo '<th class="tituloColumna">';
						echo $tituloColumna->name;
					echo '</th>';
				}
				echo '<th class="tituloColumna">';
				echo $this->acciones;
				echo '</th>';
				/*Columna de acciones*/
			echo '</tr>';
			/**FIN FILA TITULOS COLUMNA**/
			
			/**COMIENZO FILAS CON DATOS**/
			/*Para cada fila se muestran los datos recuperados*/
			$num = 0;
			while($fila = $this->resultado->fetch_row()){
				/*Se crea un formulario para dicha fila*/
				echo "<form id='formularioOpcion"; echo $num; echo "' method='GET' action='"; echo $this->controlador; echo "'>";
				/*Se crea una fila <tr>*/
				echo '<tr class="fila">';
				
				/*Se crean tantas celdas y se muestran sus datos como tenga la fila*/
				for($i = 0; $i < sizeof($fila); $i++){
					echo '<td class="celda">';
					echo "<input type='hidden' name='"; echo $this->resultado->fetch_fields()[$i]->name; echo "' value=\""; echo $fila[$i]; echo "\">";
					echo $fila[$i];
					echo '</td>';
				}
				
				/*Se crean los botones para las acciones*/
				//TODO: Poner los submit hidden y hacer un botón que haga submit de los formularios, esto es para decorar
					echo '<td class="celda">';
					if($this->showEdit){
						echo "<input class='btn btn-primary' type='submit' name='submit' value='EDIT'/>";
					}
					if($this->showDelete){
						echo "<input class='btn btn-danger' type='submit' name='submit' value='DELETE'/>";
					}
					if($this->showShowcurrent){
						echo "<input class='btn btn-primary' type='submit' name='submit' value='SHOWCURRENT'/>";
					}
					if($this->ADDHORARIO){
						echo "<input class='btn btn-secondary' type='submit' name='submit' value='ADDHORARIO'/>";
					}
					echo '</td>';
					
				echo '</tr>';
				echo '</form>';
				$num++;
			}
			/**FIN FILAS CON DATOS**/
			
		/**FIN TABLA**/
		echo '</table>';
		include '../Views/base/footer.php';
	}
} 
 ?>