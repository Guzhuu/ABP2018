<?php
/* 
	Vista para añadir una Grupo
*/
	
class Grupo_ADD{  // declaración de clase
	var $campos;
	var $controller;
	var $submit = 'ADD';

	// declaración constructor de la clase
	// se inicializa con los valores del formulario y el valor del botón submit pulsado
	function __construct(){
		$this->campos = array(
					"Grupo" => "codigo del grupo ",
					"nombre" => "nombre del Grupo",
					"CampeonatoCategoria" => "campeonato en el que está este grupo",
					"ParejaCategoria" => "parejas con su categoria pertenecientes a este grupo");
					
					
		$this->controller = 'controller_Grupo.php';
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
			
/*Fila para grupo*/
			echo '<tr class="'; echo $this->_getTr($i); echo '">';
				echo '<td class="formularioTd">';
					echo $this->campos['Grupo'];
				echo '</td>';
				
				echo '<td class="formularioTd">';
					echo '<input type="text" name="Grupo">';
					echo '</input>';
				echo '</td>';
			echo '</tr>';
			$i++;


			/*Fila para nombre*/
			echo '<tr class="'; echo $this->_getTr($i); echo '">';
				echo '<td class="formularioTd">';
					echo $this->campos['nombre'];
				echo '</td>';
				
				echo '<td class="formularioTd">';
					echo '<input type="text" name="nombre">';
					echo '</input>';
				echo '</td>';
			echo '</tr>';
			$i++;
			
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

/*Fila para ParejaCategoria*/
			echo '<tr class="'; echo $this->_getTr($i); echo '">';
				echo '<td class="formularioTd">';
					echo $this->campos['ParejaCategoria'];
				echo '</td>';
				
				echo '<td class="formularioTd">';
					echo '<input type="text" name="ParejaCategoria">';
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
		echo '</table>';
		echo '</form>';
		include_once '../Views/base/footer.php';
	} // fin método pinta()
} //fin de class muestradatos
?>