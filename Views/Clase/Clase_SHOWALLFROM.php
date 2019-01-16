<?php

class Clase_SHOWALLFROM{
	//Indican si se muestran los botones para poder hacer cada una de estas cosas. Por defecto a true
	var $showAdd = true; //Añadir clase
	var $showShowcurrent = false;
	var $showSearch = false;
	var $showAnularCurso = true;
	var $showEditHorario = true; //Editar clase
	var $showAnular = true; //Anular
	var $showVerAlumnos = true;
	
	//Obligatorio ponerlo. Indica el controlador al que ir al hacer una petición
	var $controlador;
	
	//Strings para la columna acciones
	var $acciones = 'Acciones';
	var $ADD = 'ADD';
	var $EDIT = 'EDIT';
	var $SHOWCURRENT = 'SHOWCURRENT';
	var $DELETE = 'DELETE';
	var $ANULARCURSO = 'ANULARCURSO';
	
	var $resultado;//Las tuplas a mostrar
	
	var $camposAMostrar;
	
	function __construct($respuesta){
		$this->controlador = 'Controller_Clase.php';
		$this->resultado = $respuesta;
		$this->camposAMostrar = array("nombreEscuela", "Entrenador", "Curso", "HoraInicio", "HoraFin", "codigoPista", "nombre");
		$this->campos = array(	"nombreEscuela" => "Nombre escuela", "Entrenador" => "Entrenador", "Curso" => "Curso", "HoraInicio" => "Hora de inicio", "HoraFin" => "Hora final", 
								"codigoPista" => "Pista", "nombre" => "Nombre pista");
		$this->toString();
	} // fin del constructor
	
	function botonesOpcion(){
		if($this->showEditHorario){
			echo "<input class='btn btn-secondary' type='submit' name='submit' value='EDITHORARIO'/>";
		}
		if($this->showVerAlumnos){
			echo "<input class='btn btn-secondary' type='submit' name='submit' value='VERALUMNOS'/>";
		}
		if($this->showAnularCurso){
			echo "<input class='btn btn-danger' type='submit' name='submit' value='ANULARCURSO'/>";
		}
		if($this->showAnular){
			echo "<input class='btn btn-danger' type='submit' name='submit' value='ANULARCLASE'/>";
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
				echo '<td class="celdaInvisible">';
				echo "<input class='btn btn-success' type='submit' name='submit' value='ADD'/>";
				echo '</td>';
			echo '</tr>';
			echo '</form>';
		echo '</table>';
			/**COMIENZO FILA TITULOS COLUMNA**/
		echo '<table class="table table-light">';
			echo '<tr class="fila">';
				/*Para cada field (campo) se muestra su nombre*/
				$tituloColumna = $this->resultado->fetch_field();
				while($tituloColumna = $this->resultado->fetch_field()){
					if(in_array($tituloColumna->name, $this->camposAMostrar)){
						echo '<th class="tituloColumna">';
							echo $this->campos[$tituloColumna->name];
						echo '</th>';
					}
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
					$name = $this->resultado->fetch_fields()[$i]->name;
					if(in_array($name, $this->camposAMostrar)){
						echo '<td class="celda">';
						echo "<input type='hidden' name='"; echo $name; echo "' value=\""; echo $fila[$i]; echo "\">";
						echo $fila[$i];
						echo '</td>';
					}else{
						echo "<input type='hidden' name='"; echo $name; echo "' value=\""; echo $fila[$i]; echo "\">";
					}
				}
				
				/*Se crean los botones para las acciones*/
				//TODO: Poner los submit hidden y hacer un botón que haga submit de los formularios, esto es para decorar
					echo '<td class="celda">';
						$this->botonesOpcion();
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