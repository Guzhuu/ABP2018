<?php
/* 
	Vista para editar un Deportista
*/
	
class Deportista_EDIT{  // declaración de clase
	var $deportista;
	var $campos;
	var $controller;
	var $Volver = 'Volver';
	var $submit = 'EDIT';

	// declaración constructor de la clase
	// se inicializa con los valores del formulario y el valor del botón submit pulsado
	function __construct($deportista){
		$this->deportista = $deportista;
		$this->campos = array(
					"DNI" => "DNI",
					"Edad" => "Edad",
					"Nombre" => "Nombre",
					"Apellidos" => "Apellidos",
					"Sexo" => "Sexo",
					"Contrasenha" => "Contraseña",
					"Cuota_socio" => "Cuota de Socio",
					"rolEntrenador" => "Rol Entrenador");
		$this->controller = 'Controller_Deportista.php';
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
			echo '<input type="hidden" name="DNI" value="'; echo $this->deportista->DNI; echo '">';
		
		
			
			echo '<tr class="'; echo $this->_getTr($i); echo'">';
				echo '<td class="formularioTd">';
					echo $this->campos['Edad'];
				echo '</td>';
				
				echo '<td class="formularioTd">';
					echo '<input name="Edad" type="text" value="'; echo $this->deportista->Edad; echo '">';
					echo '</input>';
				echo '</td>';
			echo '</tr>';
			$i++;

			echo '<tr class="'; echo $this->_getTr($i); echo'">';
				echo '<td class="formularioTd">';
					echo $this->campos['Nombre'];
				echo '</td>';
				
				echo '<td class="formularioTd">';
					echo '<input name="Nombre" type="text" value="'; echo $this->deportista->Nombre; echo '">';
					echo '</input>';
				echo '</td>';
			echo '</tr>';
			$i++;

			echo '<tr class="'; echo $this->_getTr($i); echo'">';
				echo '<td class="formularioTd">';
					echo $this->campos['Apellidos'];
				echo '</td>';
				
				echo '<td class="formularioTd">';
					echo '<input name="Apellidos" type="text" value="'; echo $this->deportista->Apellidos; echo '">';
					echo '</input>';
				echo '</td>';
			echo '</tr>';
			$i++;

			echo '<tr class="'; echo $this->_getTr($i); echo'">';
				echo '<td class="formularioTd">';
					echo $this->campos['Sexo'];
				echo '</td>';
				
				echo '<td class="formularioTd">';
					echo '<input name="Sexo" type="radio" value="Hombre"'; if($this->deportista->Sexo=='Hombre') echo 'checked'; echo '>Hombre<br>';
					echo '</input>';
					echo '<input name="Sexo" type="radio" value="Mujer"'; if($this->deportista->Sexo=='Mujer') echo 'checked'; echo '>Mujer<br>';
					echo '</input>';
				echo '</td>';
			echo '</tr>';
			$i++;

			echo '<tr class="'; echo $this->_getTr($i); echo'">';
				echo '<td class="formularioTd">';
					echo $this->campos['Contrasenha'];
				echo '</td>';
				
				echo '<td class="formularioTd">';
					echo '<input name="Contrasenha" type="password">';
					echo '</input>';
				echo '</td>';
			echo '</tr>';
			$i++;

			echo '<tr class="'; echo $this->_getTr($i); echo'">';
				echo '<td class="formularioTd">';
					echo $this->campos['Cuota_socio'];
				echo '</td>';
				
				echo '<td class="formularioTd">';
					echo '<input name="Cuota_socio" type="text" value="'; echo $this->deportista->Cuota_socio; echo '">';
					echo '</input>';
				echo '</td>';
			echo '</tr>';
			$i++;


			echo '<tr class="'; echo $this->_getTr($i); echo'">';
				echo '<td class="formularioTd">';
					echo $this->campos['rolEntrenador'];
				echo '</td>';
				
				echo '<td class="formularioTd">';
					echo '<input name="rolEntrenador" type="radio" value="1">Si<br>';
					echo '</input>';
					echo '<input name="rolEntrenador" type="radio" value="0" checked>No<br>';
					echo '</input>';
				echo '</td>';
			echo '</tr>';
			$i++;


			
			/*Fila para submit*/
			echo '<tr class="'; echo $this->_getTr($i); echo'">';
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