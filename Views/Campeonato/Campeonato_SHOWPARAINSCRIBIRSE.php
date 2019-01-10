<?php
/* 
	Vista para mostrar todas los campeonatos
*/

class Campeonato_SHOWPARAINSCRIBIRSE {  // declaracion de clase
	// declaracion constructor de la clase
	// se inicializa con los valores del formulario y el valor del botÃ³n submit pulsado
	var $showADDCATEGORIA = true;
	var $acciones= "Acciones";
	
	function __construct($respuesta){
		$this->controlador = 'Controller_Campeonato.php';
		$this->resultado = $respuesta;
		$this->toString();
	} // fin del constructor
	
	
	function botonesOpcion(){
		if($this->showADDCATEGORIA){
			echo "<input class='btn btn-secondary' type='submit' name='submit' value='ADDCATEGORIA'/>";
		}
	}

	function toString(){
		include '../Views/base/header.php';
			/**COMIENZO FILA TITULOS COLUMNA**/
		echo '<table class="table table-light">';
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
							echo "<input class='btn btn-primary' type='submit' name='submit' value='INSCRIBIRSE'/>";
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