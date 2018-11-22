<?php
/* 
	Vista para editar un Enfrentamiento
*/
	
class Enfrentamiento_EDIT{  // declaración de clase
	var $Enfrentamiento;
	var $campos;
	var $controller;
	var $Volver = 'Volver';
	var $submit = 'EDIT';

	// declaración constructor de la clase
	// se inicializa con los valores del formulario y el valor del botón submit pulsado
	function __construct($Enfrentamiento){
		$this->Enfrentamiento = $Enfrentamiento;
		$this->campos = array(
					"Enfrentamiento"=> "codigo de un enfrentamiento",
					"Grupo_Grupo" => "grupo al que pertenece un enfrentamiento ",
					"Pareja1" => "pareja 1 del enfrentamiento",
					"Pareja2" => "pareja 2 del enfrentamiento",
					"set1" => "set 1 del enfrentamiento",
					"set2" => "set 2 del enfrentamiento",
					"set3" => "set 3 del enfrentamiento",
		$this->controller = 'controller_Enfrentamiento.php');
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
		echo '<form method="POST" accept-charset="UTF-8" id="formularioSearch" name="formularioSearch" action="../Controllers/'; echo $this->controller; echo '">';
		echo '<table class="formulario">';
		
		

/*Fila para Enfrentamiento*/
			echo '<tr class="'; echo $this->_getTr($i); echo '">';
				echo '<td class="formularioTd">';
					echo $this->campos['Enfrentamiento'];
				echo '</td>';
				
				echo '<td class="formularioTd">';
					echo '<input type="text" name="Enfrentamiento" value="'; echo $this->Enfrentamiento->Enfrentamiento; echo'">';
					echo '</input>';
				echo '</td>';
			echo '</tr>';
			$i++;


			/*Fila para Grupo*/
			echo '<tr class="'; echo $this->_getTr($i); echo '">';
				echo '<td class="formularioTd">';
					echo $this->campos['Grupo_Grupo'];
				echo '</td>';
				
				echo '<td class="formularioTd">';
					echo '<input type="text" name="Grupo_Grupo" value="'; echo $this->Enfrentamiento->Grupo_Grupo; echo'">';
					echo '</input>';
				echo '</td>';
			echo '</tr>';
			$i++;

			/*Fila para pareja1*/
			echo '<tr class="'; echo $this->_getTr($i); echo '">';
				echo '<td class="formularioTd">';
					echo $this->campos['Pareja1'];
				echo '</td>';
				
				echo '<td class="formularioTd">';
					echo '<input type="text" name="Pareja1" value="'; echo $this->Enfrentamiento->Pareja1; echo'">';
					echo '</input>';
				echo '</td>';
			echo '</tr>';
			$i++;
			
			/*Fila para pareja2*/
			echo '<tr class="'; echo $this->_getTr($i); echo '">';
				echo '<td class="formularioTd">';
					echo $this->campos['Pareja2'];
				echo '</td>';
				
				echo '<td class="formularioTd">';
					echo '<input type="text" name="Pareja2" value="'; echo $this->Enfrentamiento->Pareja2; echo'">';
					echo '</input>';
				echo '</td>';
			echo '</tr>';
			$i++;

			/*Fila para set1*/
			echo '<tr class="'; echo $this->_getTr($i); echo '">';
				echo '<td class="formularioTd">';
					echo $this->campos['set1'];
				echo '</td>';
				
				echo '<td class="formularioTd">';
					echo '<input type="text" name="set1" value="'; echo $this->Enfrentamiento->set1; echo'">';
					echo '</input>';
				echo '</td>';
			echo '</tr>';
			$i++;

			/*Fila para set2*/
			echo '<tr class="'; echo $this->_getTr($i); echo '">';
				echo '<td class="formularioTd">';
					echo $this->campos['set2'];
				echo '</td>';
				
				echo '<td class="formularioTd">';
					echo '<input type="text" name="set2" value="'; echo $this->Enfrentamiento->set2; echo'">';
					echo '</input>';
				echo '</td>';
			echo '</tr>';
			$i++;

			/*Fila para set3*/
			echo '<tr class="'; echo $this->_getTr($i); echo '">';
				echo '<td class="formularioTd">';
					echo $this->campos['set3'];
				echo '</td>';
				
				echo '<td class="formularioTd">';
					echo '<input type="text" name="set3" value="'; echo $this->Enfrentamiento->set3; echo'">';
					echo '</input>';
				echo '</td>';
			echo '</tr>';
			$i++;


			
			/*Fila para submit*/
			echo '<tr class="'; echo $this->_getTr($i); echo '">';
				echo '<td class="formularioTd">';
					echo $this->submit;
				echo '</td>';
				
				echo '<td class="formularioTd">';
					echo '<input type="submit" name="submit" value="'; echo $this->submit; echo '">';
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
					echo '<button>'; echo $this->Volver; echo '</button>';
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


