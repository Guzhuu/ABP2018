<?php
/* 
	Vista para editar una clase
*/
	
class Clase_EDIT{  // declaración de clase
	var $clase;
	var $campos;
	var $controller;
	var $Volver = 'Volver';
	var $submit = 'EDIT';
	
	var $Escuelas;
	var $Cursos;

	// declaración constructor de la clase
	// se inicializa con los valores del formulario y el valor del botón submit pulsado
	function __construct($clase, $Escuelas, $Cursos, $Entrenadores){
		$this->clase = $clase;
		$this->campos = array(
					"Clase" => "Clase",
					"Reserva_Reserva" => "Codigo de la reserva",
					"codigoEscuela" => "Escuela",
					"Entrenador" => "Entrenador",
					"Curso" => "Curso",
					"Particulares" => "Clases particulares");
		$this->controller = 'Controller_Clase.php';
		$this->Escuelas = $Escuelas;
		$this->Cursos = $Cursos;
		$this->Entrenadores = $Entrenadores;
		$this->toString();
	}
	
	function _getTr($i){
		if($i % 2){
			return "trImpar";
		}else{
			return "trPar";
		}
	}

	function toString(){
		include_once '../Views/base/header.php';
		
		$i = 0;
		/*Tabla para el formulario*/
		echo '<form method="POST" accept-charset="UTF-8" id="formularioEdit" name="formularioEdit" action="../Controllers/'; echo $this->controller; echo '">';
		echo '<table class="formulario">';
				echo '<input type="hidden" name="Clase" readonly value="'; echo $this->clase->_getClase(); echo '">';
				echo '<input type="hidden" name="Reserva_Reserva" readonly value="'; echo $this->clase->_getReserva(); echo '">';
		
			/*Fila para codigoEscuela*/
			echo '<tr class="'; echo $this->_getTr($i); echo '">';
				echo '<td class="formularioTd">';
					echo $this->campos['codigoEscuela'];
				echo '</td>';
				
				echo '<td class="formularioTd">';
					echo '<select name="codigoEscuela">';
					for($j = 0; $j < count($this->Escuelas); $j++){
						echo '<option value="'; echo $this->Escuelas[$j][0]; echo '" '; if($this->clase->_getEscuela() == $this->Escuelas[$j][0]){echo 'selected';} echo '">'; echo $this->Escuelas[$j][1]; echo '</option>';
					}
					echo '</select>';
				echo '</td>';
			echo '</tr>';
			$i++;
			 
			if(isAdmin()){
				/*Fila para Entrenador*/
				echo '<tr class="'; echo $this->_getTr($i); echo '">';
					echo '<td class="formularioTd">';
						echo $this->campos['Entrenador'];
					echo '</td>';
					
					echo '<td class="formularioTd">';
						if(isAdmin()){
							echo '<select name="Entrenador">';
							for($j = 0; $j < count($this->Entrenadores); $j++){
								echo '<option value="'; echo $this->Entrenadores[$j][0]; echo '" '; if($this->clase->_getEntrenador() == $this->Entrenadores[$j][0]){echo ' selected ';} echo '">'; echo $this->Entrenadores[$j][0]; echo '</option>';
							}
							echo '</select>';
						}else{
							echo '<input type="text" name="Entrenador" readonly value="'; echo $_SESSION['DNI']; echo '">';
						}
						echo '</input>';
					echo '</td>';
				echo '</tr>';
				$i++;
			}else{
				echo '<input type="hidden" name="Entrenador" readonly value="'; echo $_SESSION['DNI']; echo '">';
			}

			/*Fila para Curso*/
			echo '<tr class="'; echo $this->_getTr($i); echo '">';
				echo '<td class="formularioTd">';
					echo $this->campos['Curso'];
				echo '</td>';
				
				echo '<td class="formularioTd">';
					echo '<input list="cursos" name="Curso" value="'; echo $this->clase->_getCurso(); echo '">';
					echo '<datalist id="cursos">';
					for($j = 0; $j < count($this->Cursos); $j++){
						echo '<option value="'; echo $this->Cursos[$j][0]; echo '">';
					}
					echo '</datalist>';
				echo '</td>';
			echo '</tr>';
			$i++;
		
			/*Fila para Particulares*/
			echo '<tr class="'; echo $this->_getTr($i); echo '">';
				echo '<td class="formularioTd">';
					echo $this->campos['Particulares'];
				echo '</td>';
				
				echo '<td class="formularioTd">';
					echo '<select name="Particulares">';
						if($this->clase->_getParticulares()){
							echo '<option value="0">No</option>';
							echo '<option value="1" selected>Sí</option>';
						}else{
							echo '<option value="0" selected>No</option>';
							echo '<option value="1">Sí</option>';
						}
					echo '</select>';
				echo '</td>';
			echo '</tr>';
			$i++;
			
			/*Fila para submit*/
			echo '<tr class="'; echo $this->_getTr($i); echo '">';
				echo '<td class="formularioTd">';
					echo $this->submit;
				echo '</td>';
				
				echo '<td class="formularioTd">';
					echo '<input class="btn btn-primary" type="submit" name="submit" value="'; echo $this->submit; echo '">';
					echo '</input>';
				echo '</td>';
			echo '</tr>';
			$i++;
			
			/*Fila para volver*/
			echo '<tr class="'; echo $this->_getTr($i); echo'">';
				echo '<td class="formularioTd">';
					echo $this->Volver;
				echo '</td>';
				
				echo '<td class="formularioTd">';
					echo '<a href="'; echo $this->controller; echo '">';
					echo '<button class="btn btn-secondary">'; echo $this->Volver; echo '</button>';
					echo '</a>';
				echo '</td>';
			echo '</tr>';
			$i++;
		echo '</table>';
		echo '</form>';
		include_once '../Views/base/footer.php';
	} // fin método pinta()
} //fin de class muestradatos
?>