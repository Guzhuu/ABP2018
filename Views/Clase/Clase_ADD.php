<?php
/* 
	Vista para añadir un pista
*/
	
class Clase_ADD{  // declaración de clase
	var $campos;
	var $controller;
	var $submit = 'ADD';
	var $Volver = "Volver";
	
	var $Reservas;
	var $Escuelas;
	var $Cursos;

	// declaración constructor de la clase
	// se inicializa con los valores del formulario y el valor del botón submit pulsado
	function __construct($Reservas, $Escuelas, $Cursos, $Entrenadores){
		$this->campos = array(
					"Clase" => "Clase",
					"Reserva_Reserva" => "Codigo de la reserva",
					"codigoEscuela" => "Codigo de la escuela",
					"Entrenador" => "Entrenador",
					"Curso" => "Curso",
					"Particulares" => "Clases particulares");
		$this->controller = 'Controller_Clase.php';
		$this->Reservas = $Reservas;
		$this->Escuelas = $Escuelas;
		$this->Cursos = $Cursos;
		$this->Entrenadores = $Entrenadores;
		$this->toString();
	} // fin del constructor
	
	function _getTr($i){
		if($i % 2){
			return "trImpar";
		}else{
			return "trPar";
		}
	}

	// declaración de método pinta()
	// muestra por pantall html con los valores de los atributos de la clase
	// y un hiperenlace para volver al script php que la invocó
	function toString(){
		include_once '../Views/base/header.php';
		
		$i = 0;
		/*Tabla para el formulario*/
		echo '<form method="POST" accept-charset="UTF-8" id="formularioAdd" name="formularioAdd" action="../Controllers/'; echo $this->controller; echo '">';
		echo '<table class="formulario">';
		
			/*Fila para Reserva_Reserva*/
			echo '<tr class="'; echo $this->_getTr($i); echo '">';
				echo '<td class="formularioTd">';
					echo $this->campos['Reserva_Reserva'];
				echo '</td>';
				
				echo '<td class="formularioTd">';
					echo '<select name="Reserva_Reserva">';
					for($j = 0; $j < count($this->Reservas); $j++){
						echo '<option value="'; echo $this->Reservas[$j][0]; echo '">'; echo $this->Reservas[$j][1]; echo '</option>';
					}
					echo '</select>';
				echo '</td>';
			echo '</tr>';
			$i++;
		
			/*Fila para codigoEscuela*/
			echo '<tr class="'; echo $this->_getTr($i); echo '">';
				echo '<td class="formularioTd">';
					echo $this->campos['codigoEscuela'];
				echo '</td>';
				
				echo '<td class="formularioTd">';
					echo '<select name="codigoEscuela">';
					for($j = 0; $j < count($this->Escuelas); $j++){
						echo '<option value="'; echo $this->Escuelas[$j][0]; echo '">'; echo $this->Escuelas[$j][1]; echo '</option>';
					}
					echo '</select>';
				echo '</td>';
			echo '</tr>';
			$i++;
		
			/*Fila para Entrenador*/
			echo '<tr class="'; echo $this->_getTr($i); echo '">';
				echo '<td class="formularioTd">';
					echo $this->campos['Entrenador'];
				echo '</td>';
				
				echo '<td class="formularioTd">';
					if(isAdmin()){
						echo '<select name="Entrenador">';
						for($j = 0; $j < count($this->Entrenadores); $j++){
							echo '<option value="'; echo $this->Entrenadores[$j][0]; echo '">'; echo $this->Entrenadores[$j][0]; echo '</option>';
						}
						echo '</select>';
					}else{
						echo '<input type="text" name="Entrenador" readonly value="'; echo $_SESSION['DNI']; echo '">';
					}
					echo '</input>';
				echo '</td>';
			echo '</tr>';
			$i++;

			/*Fila para Curso*/
			echo '<tr class="'; echo $this->_getTr($i); echo '">';
				echo '<td class="formularioTd">';
					echo $this->campos['Curso'];
				echo '</td>';
				
				echo '<td class="formularioTd">';
					echo '<input list="cursos" name="Curso">';
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
						echo '<option value="0">No</option>';
						echo '<option value="1">Sí</option>';
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
					echo '<input class="btn btn-success" type="submit" name="submit" value="'; echo $this->submit; echo '">';
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
		echo '</table>';
		echo '</form>';
		include_once '../Views/base/footer.php';
	} // fin método pinta()
} //fin de class muestradatos
?>