<?php
/* 
	Vista para añadir un Deportista
*/
	
class Deportista_ADD{  // declaración de clase
	var $campos;
	var $controller;
	var $submit = 'ADD';
	var $Volver = "Volver";

	// declaración constructor de la clase
	// se inicializa con los valores del formulario y el valor del botón submit pulsado
	function __construct(){
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
		echo '<script type="text/javascript" src="../js/md5.js"></script>';
		?>
		   <script>
			  function encriptarContrasenha(){
				  document.getElementById("contrasenha").value = hex_md5(document.getElementById("password").value);
			  }
		   </script>
		<?php
		
		$i = 0;
		/*Tabla para el formulario*/
		echo '<form method="POST" accept-charset="UTF-8" id="formularioAdd" name="formularioAdd" action="../Controllers/'; echo $this->controller; echo '">';
		echo '<table class="formulario">';
		
			echo '<tr class="'; echo $this->_getTr($i); echo'">';
				echo '<td class="formularioTd">';
					echo $this->campos['DNI'];
				echo '</td>';
				
				echo '<td class="formularioTd">';
					echo '<input name="DNI" type="text">';
					echo '</input>';
				echo '</td>';
			echo '</tr>';
			$i++;
			
			echo '<tr class="'; echo $this->_getTr($i); echo'">';
				echo '<td class="formularioTd">';
					echo $this->campos['Edad'];
				echo '</td>';
				
				echo '<td class="formularioTd">';
					echo '<input name="Edad" type="text">';
					echo '</input>';
				echo '</td>';
			echo '</tr>';
			$i++;

			echo '<tr class="'; echo $this->_getTr($i); echo'">';
				echo '<td class="formularioTd">';
					echo $this->campos['Nombre'];
				echo '</td>';
				
				echo '<td class="formularioTd">';
					echo '<input name="Nombre" type="text">';
					echo '</input>';
				echo '</td>';
			echo '</tr>';
			$i++;

			echo '<tr class="'; echo $this->_getTr($i); echo'">';
				echo '<td class="formularioTd">';
					echo $this->campos['Apellidos'];
				echo '</td>';
				
				echo '<td class="formularioTd">';
					echo '<input name="Apellidos" type="text">';
					echo '</input>';
				echo '</td>';
			echo '</tr>';
			$i++;

			echo '<tr class="'; echo $this->_getTr($i); echo'">';
				echo '<td class="formularioTd">';
					echo $this->campos['Sexo'];
				echo '</td>';
				
				echo '<td class="formularioTd">';

					echo '<input name="Sexo" type="radio" value="Hombre" checked>Hombre<br>';
					echo '</input>';
					echo '<input name="Sexo" type="radio" value="Mujer">Mujer<br>';
					echo '</input>';
				echo '</td>';
			echo '</tr>';
			$i++;

			echo '<tr class="'; echo $this->_getTr($i); echo'">';
				echo '<td class="formularioTd">';
					echo $this->campos['Contrasenha'];
				echo '</td>';
				
				echo '<td class="formularioTd">';
					echo '<input type="hidden" id="contrasenha" name="Contrasenha" maxlength="128" value=""/>';
					echo '<input type="password" id="password" name="password" onChange="encriptarContrasenha()">';
					echo '</input>';
				echo '</td>';
			echo '</tr>';
			$i++;

			echo '<tr class="'; echo $this->_getTr($i); echo'">';
				echo '<td class="formularioTd">';
					echo $this->campos['Cuota_socio'];
				echo '</td>';
				
				echo '<td class="formularioTd">';
					echo '<input name="Cuota_socio" type="text">';
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
