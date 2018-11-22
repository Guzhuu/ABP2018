<?php
/*Vista genérica para mostrar todo un array. */
class SHOWALL{
	//Indican si se muestran los botones para poder hacer cada una de estas cosas. Por defecto a true
	var $showEdit = true;
	var $showDelete = true;
	var $showShowcurrent = true;
	var $showAdd = true;
	var $showSearch = true;
	
	//Obligatorio ponerlo. Indica el controlador al que ir al hacer una petición
	var $controlador;
	
	//Strings para la columna acciones
	var $acciones = 'Acciones';
	var $ADD = 'ADD';
	var $EDIT = 'EDIT';
	var $SHOWCURRENT = 'SHOWCURRENT';
	var $DELETE = 'DELETE';
	
	var $resultado;//Las tuplas a mostrar
	
	// muestra por pantall html con los valores de los atributos de la clase
	// y un hiperenlace para volver al script php que la invoca
	function toString(){
		include '../Views/base/header.php';
		/**COMIENZO TABLA**/
		echo '<table class="tabla">';
			echo "<form id='AnadirBuscar' method='GET' action='"; echo $this->controlador; echo "'>";
			echo '<tr class="filaInvisible">';
				echo '<td class="celdaInvisible">';
				echo "<input class='submit' type='submit' name='submit' value='ADD'/>";
				echo '</td>';
				
				echo '<td class="celdaInvisible">';
				echo "<input class='submit' type='submit' name='submit' value='SEARCH'/>";
				echo '</td>';
			echo '</tr>';
			echo '</form>';
			/**COMIENZO FILA TITULOS COLUMNA**/
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
					if($this->EDIT){
						echo "<input class='submit' type='submit' name='submit' value='EDIT'/>";
					}
					if($this->DELETE){
						echo "<input class='submit' type='submit' name='submit' value='DELETE'/>";
					}
					if($this->SHOWCURRENT){
						echo "<input class='submit' type='submit' name='submit' value='SHOWCURRENT'/>";
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