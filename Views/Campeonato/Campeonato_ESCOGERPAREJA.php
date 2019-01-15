<?php
/* 
	Vista para añadir un Deportista
*/
	
class Campeonato_ESCOGERPAREJA{  // declaración de clase
	var $campos;
	var $Categorias;
	var $controller;
	var $submit = 'ESCOGERPAREJA';
	var $Volver = "Volver";

	// declaración constructor de la clase
	// se inicializa con los valores del formulario y el valor del botón submit pulsado
	function __construct($Categorias){
		$this->campos = array(
					"DNI_Companhero" => "Dni del Compañero",
					"Nivel" => "Nivel de la Pareja",
					"codigoCategoria" => "Nivel de la Pareja");
		$this->controller = 'Controller_Campeonato.php';
		$this->Categorias=$Categorias;
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
		echo 'Introduzca el DNI de su pareja y el nivel de la Pareja:';
		$i = 0;
		/*Tabla para el formulario*/
		echo '<form method="POST" accept-charset="UTF-8" id="formularioEscogerPareja" name="formularioEscogerPareja" action="../Controllers/'; echo $this->controller; echo '">';
		echo '<table class="formulario">';
		/*echo '<input type="hidden" name="Categoria" value="'; echo $this->Categoria->Campeonato; echo'">';
			echo '</input>';*/
			echo '<tr class="'; echo $this->_getTr($i); echo'">';
				echo '<td class="formularioTd">';
					echo $this->campos['DNI_Companhero'];
				echo '</td>';
				
				echo '<td class="formularioTd">';
					echo '<input name="DNI_Companhero" type="text">';
					echo '</input>';
				echo '</td>';

			echo '</tr>';
			$i++;
			
			/*Fila para codigoEscuela*/
			echo '<tr class="'; echo $this->_getTr($i); echo '">';
				echo '<td class="formularioTd">';
					echo $this->campos['codigoCategoria'];
				echo '</td>';
				
				echo '<td class="formularioTd">';
					echo '<select name="codigoCategoria">';
					for($j = 0; $j < count($this->Categorias); $j++){
						echo '<option value="'; echo $this->Categorias[$j][0]; echo '">'; echo $this->Categorias[$j][1]; echo' '; echo $this->Categorias[$j][2]; echo '</option>';
					}
					echo '</select>';
				echo '</td>';
			echo '</tr>';
			$i++;

			/*Fila para submit*/
			echo '<tr class="'; echo $this->_getTr($i); echo'">';
				/*echo '<td class="formularioTd">';
					echo $this->submit;
				echo '</td>';*/
				
				echo '<td class="formularioTd">';
					echo '<input class="btn btn-success" type="submit" name="submit" value="'; echo $this->submit; echo '">';
					echo '</input>';
				echo '</td>';
			echo '</tr>';
			$i++;
			
			/*Fila para volver*/
			echo '<tr class="'; echo $this->_getTr($i); echo'">';
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