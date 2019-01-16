<?php
/*Vista genérica para mostrar todo un array. */
class Enfrentamiento_SHOWALL{
	//Indican si se muestran los botones para poder hacer cada una de estas cosas. Por defecto a true
	var $showEdit = true;
	var $showDelete = true;
	var $showShowcurrent = true;
	var $showAdd = true;
	var $showSearch = true;
	var $showAcciones = true;
	
	//Obligatorio ponerlo. Indica el controlador al que ir al hacer una petición
	var $controlador;
	
	//Strings para la columna acciones
	var $acciones = 'Acciones';
	var $ADD = 'ADD';
	var $EDIT = 'EDIT';
	var $SHOWCURRENT = 'SHOWCURRENT';
	var $DELETE = 'DELETE';
	
	var $resultado;//Las tuplas a mostrar
	var $Deportistas;
	
	function __construct($respuesta, $Deportistas){
		$this->controlador = 'Controller_Enfrentamiento.php';
		$this->resultado = $respuesta;
		$this->Deportistas = $Deportistas;
		$this->toString();
	} // fin del constructor
	
	
	function botonesArriba(){
		//Implementar, si es necesario, en las vistas_SHOWALL.php
		// a poder ser acordaos de poenrlo btn-secondary en vez de btn-primary
		/*************************** EJEMPLO ************************
			echo '<td class="celdaInvisible">';
				echo "<input class='btn btn-secondary' type='submit' name='submit' value='ADDHORARIO'/>";
			echo '</td>';
		*************************************************************/
	}
	
	function botonesOpcion(){
		//Implementar, si es necesario, en las vistas_SHOWALL.php 
		// a poder ser acordaos de poenrlo btn-secondary en vez de btn-primary
		/*************************** EJEMPLO ************************
			if($this->showShowcurrent){
				echo "<input class='btn btn-secondary' type='submit' name='submit' value='SHOWCURRENT'/>";
			}
		*************************************************************/
	}
	
	function colorDe($num){
		if($num % 2 == 0){
			return "BBBBBB";
		}else{
			return "EEEEEE";
		}
	}
	
	// muestra por pantall html con los valores de los atributos de la clase
	// y un hiperenlace para volver al script php que la invoca
	function toString(){
		include '../Views/base/header.php';
		/**COMIENZO TABLA**/
		echo '<table align="center">';
			echo "<form id='AnadirBuscar' method='GET' action='"; echo $this->controlador; echo "'>";
			echo '<tr class="filaInvisible">';
				if($this->showAdd){
					echo '<td class="celdaInvisible">';
					echo "<input class='btn btn-success' type='submit' name='submit' value='ADD'/>";
					echo '</td>';
				}
				
				if($this->showSearch){
					echo '<td class="celdaInvisible">';
					echo "<input class='btn btn-primary' type='submit' name='submit' value='SEARCH'/>";
					echo '</td>';
				}
				
				$this->botonesArriba();
			echo '</tr>';
			echo '</form>';
		echo '</table>';
			/**COMIENZO FILA TITULOS COLUMNA**/
		echo '<table class="table table-light">';
			echo '<tr class="fila">';
				/*Para cada field (campo) se muestra su nombre*/
				while($tituloColumna = $this->resultado->fetch_field()){
					if($tituloColumna->name != "Enfrentamiento"){
						echo '<th class="tituloColumna">';
							echo $tituloColumna->name;
						echo '</th>';
					}
				}
				if($this->showAcciones){
					echo '<th class="tituloColumna">';
					echo $this->acciones;
					echo '</th>';
				}
				/*Columna de acciones*/
			echo '</tr>';
			/**FIN FILA TITULOS COLUMNA**/
			
			/**COMIENZO FILAS CON DATOS**/
			/*Para cada fila se muestran los datos recuperados*/
			$num = 0;
			$numFila = 0;
			while($fila = $this->resultado->fetch_row()){
				/*Se crea un formulario para dicha fila*/
				echo "<form id='formularioOpcion"; echo $num; echo "' method='GET' action='"; echo $this->controlador; echo "'>";
				/*Se crea una fila <tr>*/
				echo '<tr class="fila" bgcolor="' . $this->colorDe($numFila) . '">';
				
				/*Se crean tantas celdas y se muestran sus datos como tenga la fila*/
				for($i = 0; $i < sizeof($fila); $i++){
					$field = $this->resultado->fetch_fields()[$i]->name;
					if($field != "Enfrentamiento"){
						echo '<td class="celda">';
						echo "<input type='hidden' name='"; echo $field; echo "' value=\""; echo $fila[$i]; echo "\">";
						if($field === "SegundaRonda"){
							switch($fila[$i]){
								case 0:
									echo "Grupos";
								break;
								case 1:
									echo "Final";
								break;
								case 2:
									echo "Semifinal";
								break;
								case 3:
									echo "Tercer-Cuarto";
								break;
								case 4:
									echo "Cuartos";
								break;
								default:
									echo "";
								break;
							}
						}else if($field === "Pareja1" || $field === "Pareja2"){
							echo $fila[$i] . "</br><b>" . $this->Deportistas[substr($fila[$i], 0, 9)] . "</br>" . $this->Deportistas[substr($fila[$i], 9, 9)] . "</b>";
						}else{
							echo $fila[$i];
						}
						echo '</td>';
					}else{
						echo "<input type='hidden' name='"; echo $field; echo "' value=\""; echo $fila[$i]; echo "\">";
					}
				}
				
				/*Se crean los botones para las acciones*/
				//TODO: Poner los submit hidden y hacer un botón que haga submit de los formularios, esto es para decorar
				if($this->showAcciones){
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
						$this->botonesOpcion();
					echo '</td>';
				}
					
				echo '</tr>';
				$numFila++;
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