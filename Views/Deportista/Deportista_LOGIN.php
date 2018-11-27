<?php
/* 
	Vista para logearse
*/
	
class Deportista_LOGIN{  // declaración de clase
	var $campos;
	var $controller;
	var $submit = 'Login';

	// declaración constructor de la clase
	// se inicializa con los valores del formulario y el valor del botón submit pulsado
	function __construct(){
		$this->campos = array(
					"DNI" => "DNI", 
					"contrasenha" => "Contraseña");
		$this->controller = 'Controller_Login.php';
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
				  document.getElementById("password").value = document.getElementById("contrasenha").value;
			  }
		   </script>
		<?php
		$i = 0;
		/*Tabla para el formulario*/
		echo '<form method="POST" accept-charset="UTF-8" id="formularioLogin" name="formularioLogin" action="../Controllers/'; echo $this->controller; echo '">';
		echo '<table class="formulario">';
			
			/*Fila para DNI*/
			echo '<tr class="'; echo $this->_getTr($i); echo '">';
				echo '<td class="formularioTd">';
					echo $this->campos['DNI'];
				echo '</td>';
				
				echo '<td class="formularioTd">';
					echo '<input type="text" name="DNI">';
					echo '</input>';
				echo '</td>';
			echo '</tr>';
			$i++;
			
			/*Fila para pass*/
			echo '<tr class="'; echo $this->_getTr($i); echo '">';
				echo '<td class="formularioTd">';
					echo $this->campos['contrasenha'];
				echo '</td>';
				
				echo '<td class="formularioTd">';
					echo '<input type="hidden" id="contrasenha" name="contrasenha" maxlength="128" value=""/>';
					echo '</form>';
					echo '<input type="password" id="password" name="password" onChange="encriptarContrasenha()">';
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
		echo '</table>';
		include_once '../Views/base/footer.php';
	} // fin método pinta()
} //fin de class muestradatos
?>