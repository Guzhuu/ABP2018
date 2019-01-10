<?php
/* 
	Vista para editar un Categoria
*/
	
class Categoria_EDIT{  // declaración de clase
	var $Categoria;
	var $campos;
	var $controller;
	var $Volver = 'Volver';
	var $submit = 'EDIT';

	// declaración constructor de la clase
	// se inicializa con los valores del formulario y el valor del botón submit pulsado
	function __construct($Categoria){
		$this->Categoria = $Categoria;
		$this->campos = array(
					"Categoria" => "Codigo de la Categoria",
					"Nivel" => "Nivel",
					"Sexo" => "Sexo");
		$this->controller = 'Controller_Categoria.php';
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
			echo '<input type="hidden" name="Categoria" value="'; echo $this->Categoria->Categoria; echo'">';
			echo '</input>';

			/*Fila para Nivel*/
			echo '<tr class="'; echo $this->_getTr($i); echo '">';
				echo '<td class="formularioTd">';
					echo $this->campos['Nivel'];
				echo '</td>';
				
				echo '<td class="formularioTd">';
					echo '<input type="text" name="Nivel" value="'; echo $this->Categoria->Nivel; echo'">';
					echo '</input>';
				echo '</td>';
			echo '</tr>';
			$i++;
			
			/*Fila para Sexo*/
			echo '<tr class="'; echo $this->_getTr($i); echo '">';
				echo '<td class="formularioTd">';
					echo $this->campos['Sexo'];
				echo '</td>';
				
				echo '<td class="formularioTd">';
					echo '<select name="Sexo">';
						echo '<option value="M"'; if($this->Categoria->Sexo === 'M'){echo 'selected';} echo'>Masculino</option>';
						echo '<option value="F"'; if($this->Categoria->Sexo === 'F'){echo 'selected';} echo'>Femenino</option>';
						echo '<option value="MX"'; if($this->Categoria->Sexo === 'MX'){echo 'selected';} echo'>Mixto</option>';
					echo '</select>';
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