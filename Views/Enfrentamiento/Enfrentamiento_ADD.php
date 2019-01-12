<?php
/* 
	Vista para añadir una Enfrentamiento
*/
	
class Enfrentamiento_ADD{  // declaración de clase
	var $campos;
	var $controller;
	var $submit = 'ADD';
	var $Volver = "Volver";

	// declaración constructor de la clase
	// se inicializa con los valores del formulario y el valor del botón submit pulsado
	function __construct(){
		$this->campos = array(
					"Enfrentamiento"=> "codigo de un enfrentamiento",
					"Nombre" => "Nombre del grupo",
					"CampeonatoCategoria" => "Campeonato del enfrentamiento",
					"Pareja1" => "Pareja 1 del enfrentamiento",
					"Pareja2" => "Pareja 2 del enfrentamiento",
					"set1" => "Primer set",
					"set2" => "Segundo set",
					"set3" => "Tercer set");
					
		$this->controller = 'controller_Enfrentamiento.php';
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

			/*Fila para CampeonatoCategoria*/
			echo '<tr class="'; echo $this->_getTr($i); echo '">';
				echo '<td class="formularioTd">';
					echo $this->campos['CampeonatoCategoria'];
				echo '</td>';
				
				echo '<td class="formularioTd">';
					echo '<input type="text" name="CampeonatoCategoria">';
					echo '</input>';
				echo '</td>';
			echo '</tr>';
			$i++;

			/*Fila para Nombre*/
			echo '<tr class="'; echo $this->_getTr($i); echo '">';
				echo '<td class="formularioTd">';
					echo $this->campos['Nombre'];
				echo '</td>';
				
				echo '<td class="formularioTd">';
					echo '<input type="text" name="Nombre">';
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
					echo '<input type="text" name="Pareja1">';
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
					echo '<input type="text" name="Pareja2">';
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
					echo '<input type="text" name="set1">';
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
					echo '<input type="text" name="set2">';
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
					echo '<input type="text" name="set3">';
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