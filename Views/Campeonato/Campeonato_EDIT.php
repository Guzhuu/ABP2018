<?php
/* 
	Vista para editar un Campeonato
*/
	
class Campeonato_EDIT{  // declaración de clase
	var $Campeonato;
	var $campos;
	var $controller;
	var $Volver = 'Volver';
	var $submit = 'EDIT';

	// declaración constructor de la clase
	// se inicializa con los valores del formulario y el valor del botón submit pulsado
	function __construct($Campeonato){
		$this->Campeonato = $Campeonato;
		$this->campos = array(
					"Campeonato" => "Codigo del Campeonato",
					"FechaInicio" => "fecha de inicio del campeonato",
					"FechaFinal" => "fecha final del campeonato",
					"Nombre" => "nombre del campeonato");

		$this->controller = 'controller_Campeonato.php';
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
		
			echo '<input type="hidden" name="Campeonato" value="'; echo $this->Campeonato->Campeonato; echo'">';
			echo '</input>';
	
			/*Fila para FechaInicio*/
			echo '<tr class="'; echo $this->_getTr($i); echo '">';
				echo '<td class="formularioTd">';
					echo $this->campos['FechaInicio'];
				echo '</td>';
				
				echo '<td class="formularioTd">';
					echo '<input type="text" name="FechaInicio" value="'; echo $this->Campeonato->FechaInicio; echo'">';
					echo '</input>';
				echo '</td>';
			echo '</tr>';
			$i++;
			
			/*Fila para FechaFinal*/
			echo '<tr class="'; echo $this->_getTr($i); echo '">';
				echo '<td class="formularioTd">';
					echo $this->campos['FechaFinal'];
				echo '</td>';
				
				echo '<td class="formularioTd">';
					echo '<input type="text" name="FechaFinal" value="'; echo $this->Campeonato->FechaFinal; echo'">';
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
					echo '<input type="text" name="Nombre" value="'; echo $this->Campeonato->Nombre; echo'">';
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