<?php
/*Vista para añdir una categoria a un campeonato */
class Campeonato_ADDCATEGORIA{
	
	//Obligatorio ponerlo. Indica el controlador al que ir al hacer una petición
	var $controlador;
	
	var $campos;
	
	var $categoriasyCampeonatos;
	
	var $Volver = 'Volver';
	
	function __construct($categoriasyCampeonatos){
		$this->controlador = 'Controller_Campeonato.php';
		$this->campos = array(
					"Campeonato" => "Codigo del campeonato",
					"Categoria" => "codigo de la categoria",
					"Nivel" => "nivel de la pista",
					"Sexo" => "Sexo de la categoria",
					"FechaInicio" => "Fecha de inicio del campeonato");
					"FechaFecha" => "Fecha de fin de campeonato");
					"Nombre" => "Nombre del campeonato");

		$this->categoriasyCampeonatos = $categoriasyCampeonatos;
		$this->toString();
	}
	
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
		
		echo '<table class="detalle">';
			$i = 0;

			while($fila = $this->categoriasyCampeonatos->fetch_row()){
				if($i == 0){
					echo '<tr class="'; echo $this->_getTr($i); echo'">';
						echo '<td class="formularioTd">';
							echo $this->campos['Nombre'];
						echo '</td>';
						
						echo '<td class="mensaje">';
							echo $fila[1];
						echo '</td>';
					echo '</tr>';
					$i++;
					echo '<tr class="'; echo $this->_getTr($i); echo'">';
						echo '<td class="formularioTd">';
							echo $this->campos['Categoria'];
						echo '</td>';
					echo '<td class="mensaje">';
				}
				echo '<form method="POST" accept-charset="UTF-8" id="addCategoria'; echo $i; echo '" name="addCategoria'; echo $i; echo '" action="../Controllers/'; echo $this->controlador; echo '">';
				echo '<b class="lblBtCategoria"> Desde las ' . $fila[3] . ' hasta las ' . $fila[4] . '</b>';
				echo '<input type="hidden" name="Campeonato" value="'; echo $fila[0]; echo '"/>';
				echo '<input type="hidden" name="Categoria" value="'; echo $fila[2]; echo '"/>';
				echo '<input type="submit" name="submit" style="width:100%" value="ADDCATEGORIA"/><br/><br/>';
				$i++;
				echo '</form>';
			}
			echo '</td>';
			echo '</tr>';
			/*Fila para volver*/
			echo '<tr class="'; echo $this->_getTr($i); echo'">';
				echo '<td class="formularioTd">';
					echo $this->Volver;
				echo '</td>';
				
				echo '<td class="formularioTd">';
					echo '<a href="'; echo $this->controlador; echo '">';
					echo '<button>'; echo $this->Volver; echo '</button>';
					echo '</a>';
				echo '</td>';
			echo '</tr>';
			
		/**FIN TABLA**/
		echo '</table>';
		include '../Views/base/footer.php';
	}
}
?>