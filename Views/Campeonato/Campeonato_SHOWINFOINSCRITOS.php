<?php
/* 
	Vista para mostrar todas los campeonatos
*/
//include '../Views/base/SHOWALL.php';

class Campeonato_SHOWINFOINSCRITOS{
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
	
	var $CodigoPareja = "Codigo de Pareja";
	var $Pareja = "Cod. Pareja";
	var $Categorias = "Categorias";
	var $Nivel = "Nivel";
	var $Sexo = "Sexo";
	var $showInscribirseCategoria= true;
	var $showAddcategoria = true;
	var $showGenerarcalendario = true;
	var $showGenerarCuartos = true;
	var $showGenerarRankingfinal = true;
	var $showQuitarCategoria = true;
	
	function __construct($respuesta, $ParejaPerteneceCategoriaCampeonato){
		$this->controlador = 'Controller_Campeonato.php';
		$this->resultado = $respuesta;
		$this->toString($ParejaPerteneceCategoriaCampeonato);
	} // fin del constructor
	
	
	function botonesArriba(){
	}
	
	
	/*function botonesOpcion(){
		if($this->showAddcategoria){
			echo "<input class='btn btn-secondary' type='submit' name='submit' value='ADDCATEGORIA'/>";
		}
		echo '</br>';
		echo '</br>';
		if($this->showGenerarcalendario){
			echo "<input class='btn btn-secondary' type='submit' name='submit' value='GENERARCALENDARIO'/>";
		}
		if($this->showGenerarCuartos){
			echo "<input class='btn btn-secondary' type='submit' name='submit' value='GENERARCUARTOS'/>";
		}
		if($this->showGenerarRankingfinal){
			echo "<input class='btn btn-secondary' type='submit' name='submit' value='GENERARRANKINGFINAL'/>";
		}
	}*/
	
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
	
	function toString($ParejaPerteneceCategoriaCampeonato){
		include '../Views/base/header.php';
		/**COMIENZO TABLA**/
		
			/**COMIENZO FILA TITULOS COLUMNA**/
		echo '<table class="table table-light">';

			echo '<tr class="fila">';
			echo '<th class="tituloColumna" style= "text-align:center" colspan="5">';
							echo 'Pareja inscrita satisfactoriamente. Detalles acerca de su participación:';
						echo '</th>';
			echo '</tr>';
			
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
				echo $this->Categorias;
				echo '</th>';
				
				
				/*Columna de acciones*/
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
					echo '<table class="table table-light">';
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
							echo "<form id='formularioInscribirse"; echo $num2; echo "' method='GET' action='"; echo $this->controlador; echo "'>";
							/*echo '<input type="hidden" name="codPareja" value="'; echo $ParejaPerteneceCategoriaCampeonato->; echo'">';
							//var_dump($ParejaPerteneceCategoria->Pareja_codPareja);
							echo '</input>';
							echo '<input type="hidden" name="perteneceCategoria" value="'; echo $ParejaPerteneceCategoriaCampeonato->perteneceCategoria; echo'">';
							//var_dump($ParejaPerteneceCategoria->perteneceCategoria);
							echo '</input>';*/
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