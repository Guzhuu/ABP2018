<?php
/* 
	Vista para mostrar todas los campeonatos
*/
//include '../Views/base/SHOWALL.php';

class Campeonato_SHOWALLFORUSER{
	var $showShowcurrent = true;
	var $showAcciones = true;
	
	//Obligatorio ponerlo. Indica el controlador al que ir al hacer una petición
	var $controlador;
	
	var $resultado;//Las tuplas a mostrar
	
	var $categorias = "Categorias";
	var $Nivel = "Nivel";
	var $Sexo = "Sexo";	
	var $acciones= "Acciones";
	var $showGenerarRanking = true;
	var $showGenerarRankingfinal = true;

	function __construct($respuesta){
		$this->controlador = 'Controller_Campeonato.php';
		$this->resultado = $respuesta;
		$this->toString();
	} // fin del constructor
	
	
	function sexoDe($string){
		if($string === 'M'){
			return 'Masculino';
		}else if($string === 'F'){
			return 'Femenino';
		}else{
			return 'Mixto';
		}
	}
	
	function colorDe($num){
		if($num % 2 == 0){
			return "BBBBBB";
		}else{
			return "EEEEEE";
		}
	}
	

	function botonesOpcion(){
		
		if($this->showGenerarRanking){
			echo "<input class='btn btn-warning' type='submit' name='submit' value='RANKINGGRUPOS'/>";
		}
		echo '</br>';
		
		if($this->showGenerarRankingfinal){
			echo "<input class='btn btn-warning' type='submit' name='submit' value='RANKINGFINAL'/>";
		}
	}
	
	function toString(){
		include '../Views/base/header.php';
		/**COMIENZO TABLA**/
		
			/**COMIENZO FILA TITULOS COLUMNA**/
		echo '<table class="table table-light">';
			echo '<tr class="fila">';
				/*Para cada field (campo) se muestra su nombre*/
				$contador = 0;
				while($tituloColumna = $this->resultado->fetch_field()){
					if($contador < 4){
						echo '<th class="tituloColumna">';
							echo $tituloColumna->name;
						echo '</th>';
					}
					$contador++;
				}
				
				echo '<th class="tituloColumna">';
				echo $this->categorias;
				echo '</th>';
				
				if($this->showAcciones){
					echo '<th class="tituloColumna">';
					echo $this->acciones;
					echo '</th>';
				}
			echo '</tr>';
			/**FIN FILA TITULOS COLUMNA**/
			
			/**COMIENZO FILAS CON DATOS**/
			/*Para cada fila se muestran los datos recuperados*/
			$num = 0;
			$num2 = 0;
			$numFila = 0;
			$numFila2 = 0;
			$prev = '';
			$fila = $this->resultado->fetch_row();
			while($fila){
				$prev = $fila[0];
				/*Se crea una fila <tr>*/
				echo '<tr class="fila" bgcolor="' . $this->colorDe($numFila) . '">';
				
				/*Se crean tantas celdas y se muestran sus datos como tenga la fila*/
				for($i = 0; $i < 4; $i++){
					echo '<td class="celda">';
					echo $fila[$i];
					echo '</td>';
				}
				
				echo '<td class="celda">';
					echo '<table class="table table-light table-bordered">';
					echo '<th>';
					echo $this->Nivel;
					echo '</th>';
					echo '<th>';
					echo $this->Sexo;
					echo '</th>';
					$categoriasDeFila = $fila;
					while($categoriasDeFila[0] == $prev){
						if($categoriasDeFila[4] != null){
							echo '<tr bgcolor="' . $this->colorDe($numFila2) . '">';
							echo "<form id='formularioQuitar"; echo $num2; echo "' method='GET' action='"; echo $this->controlador; echo "'>";
							echo "<input type='hidden' name='Campeonato' value=\""; echo $fila[0]; echo "\">";
							echo "<input type='hidden' name='Categoria' value=\""; echo $categoriasDeFila[4]; echo "\">";
							echo '<td>'; echo $categoriasDeFila[5]; echo '</td>';
							echo '<td>'; echo $this->sexoDe($categoriasDeFila[6]); echo '</td>';
							
							echo '</form>';
							echo '</tr>';
							$numFila2++;
							$num2++;
						}
						$categoriasDeFila = $this->resultado->fetch_row();
					}
					echo '</table>';
					echo '</td>';
				
				/*Se crea un formulario para dicha fila*/
				echo "<form id='formularioOpcion"; echo $num; echo "' method='GET' action='"; echo $this->controlador; echo "'>";
				for($i = 0; $i < sizeof($fila); $i++){
					echo "<input type='hidden' name='"; echo $this->resultado->fetch_fields()[$i]->name; echo "' value=\""; echo $fila[$i]; echo "\">";
				}
				$fila = $categoriasDeFila;
				
				
				/*Se crean los botones para las acciones*/
				//TODO: Poner los submit hidden y hacer un botón que haga submit de los formularios, esto es para decorar
				if($this->showAcciones){
					echo '<td class="celda">';
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