<?php
/*Vista genérica para mostrar un array de pistas. */
class Reserva_RESERVAR{
	
	//Obligatorio ponerlo. Indica el controlador al que ir al hacer una petición
	var $controlador;
	
	var $campos;
	
	var $pistasyHorarios;
	
	var $Volver = "Volver";
	
	function __construct($pistasyHorarios){
		$this->controlador = 'Controller_Reserva.php';
		$this->campos = array("codigoPistayHorario", "Pista_codigoPista", "nombre", "Horario_Horario", "HoraInicio", "HoraFin", "DNI_Deportista");
		$this->camposValue = array(	"codigoPistayHorario" => "Codigo de pista y horario",
								"Pista_codigoPista" => "Codigo de pista",
								"nombre" => "Nombre de la pista",
								"Horario_Horario" => "Codigo del horario",
								"HoraInicio" => "Hora inicio reserva", 
								"HoraFin" => "Hora fin de reserva", 
								"DNI_Deportista" => "DNI",
								"Reservar" => "Reservar");
		$this->pistasyHorarios = $pistasyHorarios->fetch_all();
		$this->toString();
	}
	
	// muestra por pantall html con los valores de los atributos de la clase
	// y un hiperenlace para volver al script php que la invoca
	function toString(){	
		include '../Views/base/header.php';
		echo '<table class="detalle">';
			echo "<tr class='trPar'>";
				echo "<td>";
				$pistaPrev = '';
				$contForms = 0;
					for($i = 0; $i < sizeof($this->pistasyHorarios); $i++){
						if($pistaPrev != $this->pistasyHorarios[$i][2]){
							if($i != 0){
									echo '</tbody>';
								echo '</table>';
							echo '</form>';
							}
								/******************************GENERACION DE TABLA******************************/
							echo '</br>';
							echo '</br>';
								/******************************GENERACION DE TABLA******************************/
								echo '<table class="table table-bordered table-dark">';
									echo '<thead>';
										echo '<tr>';
											echo '<th class="text-center" colspan="3"><h2>' . $this->pistasyHorarios[$i][2] . '</h2></th>';
										echo '</tr>';
										echo '<tr>';
											echo '<th scope="col">' . $this->camposValue["HoraInicio"] . '</th>';
											echo '<th scope="col">' . $this->camposValue["HoraFin"] . '</th>';
											echo '<th scope="col">' . $this->camposValue["Reservar"] . '</th>';
										echo '</tr>';
									echo '</thead>';
									echo '<tbody>';	
										echo '<tr>';
											echo "<form id='formularioOpcion"; echo $contForms++; echo "' method='POST' action='"; echo $this->controlador; echo "'>";
											echo "<input type='hidden' name='codigoPistayHorario' value='" . $this->pistasyHorarios[$i][0] . "' />";
											echo "<input type='hidden' name='Pista_codigoPista' value='" . $this->pistasyHorarios[$i][1] . "' />";
											echo "<input type='hidden' name='Horario_Horario' value='" . $this->pistasyHorarios[$i][3] . "' />";
											echo '<td>' . $this->pistasyHorarios[$i][4] . '</td>';
											echo '<td>' . $this->pistasyHorarios[$i][5] . '</td>';
											echo '<td><input type="submit" class="btn btn-primary" value="RESERVAR"/></td>';
										echo '</form>';
										echo '</tr>';
							$pistaPrev = $this->pistasyHorarios[$i][2];
						}else{
										echo '<tr>';
											echo "<form id='formularioOpcion"; echo $contForms++; echo "' method='POST' action='"; echo $this->controlador; echo "'>";
											echo "<input type='hidden' name='codigoPistayHorario' value='" . $this->pistasyHorarios[$i][0] . "' />";
											echo "<input type='hidden' name='Pista_codigoPista' value='" . $this->pistasyHorarios[$i][1] . "' />";
											echo "<input type='hidden' name='Horario_Horario' value='" . $this->pistasyHorarios[$i][3] . "' />";
											echo '<td>' . $this->pistasyHorarios[$i][4] . '</td>';
											echo '<td>' . $this->pistasyHorarios[$i][5] . '</td>';
											echo '<td><input type="submit" class="btn btn-primary" value="RESERVAR"/></td>';
										echo '</form>';
										echo '</tr>';
						}
					}
							echo '</tbody>';
						echo '</table>';
					echo '</form>';
				echo "</td>";
			echo "</tr>";
			
			echo "<tr class='trImpar'>";
				echo "<td class='mensaje'>";
				echo '</br>';
				echo "<a href="; echo $this->controlador; echo '><button class="btn btn-secondary"><h2>' . $this->Volver . '</h2></button></a></td>';
				echo '</br>';
				echo "</td>";
			echo "</tr>";
		echo "</table>";
		include '../Views/base/footer.php';
	}
}
?>