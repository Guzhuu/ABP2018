<?php 
/* 
	Para ver clasificaciones
*/
class Campeonato_CLASIFICACION{
	var $Cuadro;
	var $Volver = 'Volver';
	var $retorno;
	
	function __construct($Cuadro, $retorno){
		$this->Cuadro = $Cuadro;
		$this->retorno = $retorno;
		$this->toString();
	}
	
	var $Capitan = "Capitán";
	var $Companhero = "Compañero";
	
	var $strCapitan = "Capitan";
	var $strCompanhero = "Companhero";
	var $strJugados = "Jugados";
	var $strGanados = "Ganados";
	var $strPerdidos = "Perdidos";
	var $strPuntos = "Puntos";
	
	function usortCustom($a, $b){
		if ($a[$this->strPuntos] == $b[$this->strPuntos]) {
			if ($a[$this->strJugados] == $b[$this->strJugados]) {
				return 0;
			}else{
				return ($a[$this->strJugados] < $b[$this->strJugados]) ? 1 : -1;
			}
		}
		
		return ($a[$this->strPuntos] < $b[$this->strPuntos]) ? 1 : -1;
	}
	
	function toString(){		
		include '../Views/base/header.php';
		echo '<table class="detalle">';
			echo "<tr class='trPar'>";
				echo "<td>";
					foreach ($this->Cuadro as $categoria => $grupos){
						echo "<center><h1><b>" . $categoria . "</b></h1></center>"; //TODO: M a masculino, F a ...
						echo '</br>';
						
						if(!is_string($grupos)){
							foreach ($grupos as $grupo => $parejas){
								echo "<center><b><h3>Grupo " . $grupo . "</h3></b></center>"; //TODO: M a masculino, F a ...
								echo '</br>';
								
								$Posicion = 1;
								usort($parejas, array($this, "usortCustom"));
								/******************************GENERACION DE TABLA******************************/
								echo '<table class="table table-bordered table-dark">';
									echo '<thead>';
										echo '<tr>';
											echo '<th scope="col">#</th>';
											echo '<th scope="col">' . $this->Capitan . '</th>';
											echo '<th scope="col">' . $this->Companhero . '</th>';
											echo '<th scope="col">' . $this->strJugados . '</th>';
											echo '<th scope="col">' . $this->strGanados . '</th>';
											echo '<th scope="col">' . $this->strPerdidos . '</th>';
											echo '<th scope="col">' . $this->strPuntos . '</th>';
										echo '</tr>';
									echo '</thead>';
									echo '<tbody>';
									foreach($parejas as $index => $datos){
										echo '<tr>';
											echo '<th scope="row">' . $Posicion++ . 'ª</th>';
											echo '<td>' . $datos[$this->strCapitan] . '</td>';
											echo '<td>' . $datos[$this->strCompanhero] . '</td>';
											echo '<td>' . $datos[$this->strJugados] . '</td>';
											echo '<td>' . $datos[$this->strGanados] . '</td>';
											echo '<td>' . $datos[$this->strPerdidos] . '</td>';
											echo '<td>' . $datos[$this->strPuntos] . '</td>';
										echo '</tr>';
									}
									echo '</tbody>';
								echo '</table>';
								/******************************GENERACION DE TABLA******************************/
							}
							echo '</br>';
							echo '</br>';
						}else{
							echo '</br>';
							echo '</br>';
							echo "<center>" . $grupos . ' <b>' . $categoria . "</b></center>";
							echo '</br>';
							echo '</br>';
						}
					}
				echo "</td>";
			echo "</tr>";
			
			echo "<tr class='trImpar'>";
				echo "<td class='mensaje'>";
				echo "<a href="; echo $this->retorno; echo '><button class="btn btn-secondary">Volver</button></a></td>';
				echo "</td>";
			echo "</tr>";
		echo "</table>";
		include '../Views/base/footer.php';
	}	
}
?>