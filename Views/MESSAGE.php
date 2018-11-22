<?php 
/* 
	Para visionar mensajes 
*/
class Mensaje{
	var $mensaje;
	var $INFO = 'INFO';
	var $VOLVER = 'Volver';
	var $retorno;
	
	function __construct($mensaje, $retorno){
		$this->mensaje = $mensaje;
		$this->retorno = $retorno;
		$this->toString();
	}
	
	function toString(){		
		include '../Views/base/header.php';
		echo '<table class="detalle">';
			echo "<tr class='trPar'>";
				echo "<td class='formularioTd'>";
				echo $this->INFO;
				echo "</td>";
				
				echo "<td class='mensaje'>";
				echo $this->mensaje;
				echo "</td>";
			echo "</tr>";
			
			echo "<tr class='trImpar'>";
				echo "<td class='formularioTd'>";
				echo $this->VOLVER;
				echo "</td>";
				
				echo "<td class='mensaje'>";
				echo "<a href="; echo $this->retorno; echo '><button class="btn btn-secondary">Volver</button></a></td>';
				echo "</td>";
			echo "</tr>";
		echo "</table>";
		include '../Views/base/footer.php';
	}	
}
?>