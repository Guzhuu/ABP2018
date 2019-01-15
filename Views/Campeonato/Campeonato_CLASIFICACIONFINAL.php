<?php 
/* 
	Para ver clasificaciones de cuartos
*/
class Campeonato_CLASIFICACIONFINAL{
	var $Cuadro;
	var $Volver = 'Volver';
	var $retorno;
	
	function __construct($Cuadro, $retorno){
		$this->Cuadro = $Cuadro;
		$this->ordenarCuadro();
		$this->retorno = $retorno;
		$this->toString();
	}
	
	var $Capitan = "Capitán";
	var $Companhero = "Compañero";
	
	var $strCapitan = "Capitan";
	var $strCompanhero = "Companhero";
	var $strPosicion = "Posicion";
	
	function ordenarCuadro(){
		foreach($this->Cuadro as $categoria => $clasificacion){
			if(!is_string($clasificacion)){
				uasort($this->Cuadro[$categoria], array($this, "usortRankingFinal"));
			}
		}
	}
	
	function usortRankingFinal($a, $b){
		if ($a[$this->strPosicion] == $b[$this->strPosicion]) {
			return 0;
		}
		
		return ($a[$this->strPosicion] < $b[$this->strPosicion]) ? -1 : 1;
	}
	
	function classDe($Posicion){
		if($Posicion == 1){
			return 'bgcolor="#ffd700"';
		}else if($Posicion == 2){
			return 'bgcolor="#c0c0c0"';
		}else if($Posicion == 3){
			return 'bgcolor="#cd7f32"';
		}else if($Posicion == 4){
			return 'bgcolor="#009900"';
		}else{
			return 'scope="row"';
		}
	}
	
	function toString(){		
		include '../Views/base/header.php';
		echo '<table class="detalle">';
			echo "<tr class='trPar'>";
				echo "<td>";
					foreach ($this->Cuadro as $categoria => $clasificacion){
						echo "<center><h1><b>" . explode(":", $categoria)[1] . "</b></h1></center>"; //TODO: M a masculino, F a ...
						echo '</br>';
						
						if(!is_string($clasificacion)){
							/******************************GENERACION DE TABLA******************************/
							echo '<table class="table table-bordered table-dark">';
								echo '<thead>';
									echo '<tr>';
										echo '<th scope="col">#</th>';
										echo '<th scope="col">' . $this->Capitan . '</th>';
										echo '<th scope="col">' . $this->Companhero . '</th>';
									echo '</tr>';
								echo '</thead>';
								echo '<tbody>';
							foreach ($clasificacion as $clasificado => $datos){
									echo '<tr>';
										echo '<th ' . $this->classDe($datos[$this->strPosicion]) . '>' . $datos[$this->strPosicion] . 'ª</th>';
										echo '<td>' . $datos[$this->strCapitan] . '</td>';
										echo '<td>' . $datos[$this->strCompanhero] . '</td>';
									echo '</tr>';
							}
								echo '</tbody>';
							echo '</table>';
							/******************************GENERACION DE TABLA******************************/
							echo '</br>';
							echo '</br>';
						}else{
							echo '</br>';
							echo '</br>';
							echo "<center>" . $clasificacion . ' <b>' . explode(":", $categoria)[1] . "</b></center>";
							echo '</br>';
							echo '</br>';
						}
					}
				echo "</td>";
			echo "</tr>";
			
			echo "<tr class='trImpar'>";
				echo "<td class='mensaje'>";
				echo '</br>';
				echo "<a href="; echo $this->retorno; echo '><button class="btn btn-secondary"><h2>Volver</h2></button></a></td>';
				echo '</br>';
				echo "</td>";
			echo "</tr>";
		echo "</table>";
		include '../Views/base/footer.php';
	}	
}
?>