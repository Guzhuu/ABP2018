<?php
class Escuela{
	public $codigoEscuela;
	public $nombreEscuela;
	var $mysqli;

	function __construct($codigoEscuela, $nombreEscuela){
  		$this->codigoEscuela = $codigoEscuela;
  		$this->nombreEscuela = $nombreEscuela;
		
		include_once '../Functions/ConectarBD.php'; //Actualizar
		$this->mysqli = ConectarBD();
	}

	public function _getCodigoEscuela(){
		return $this->codigoEscuela;
	}

	public function _getNombreEscuela(){
		return $this->nombreEscuela;
	}


	public function _setCodigoEscuela($codigoEscuela){
		$this->codigoEscuela = $codigoEscuela;
	}

	public function _setNombreEscuela($nombreEscuela){
		$this->nombreEscuela = $nombreEscuela;
	}


    function _getDatosGuardados(){//Para recuperar de la base de datos
		if(($this->_getCodigoEscuela() == '')){
			return 'Codigo de escuela vacia, introduzca una escuela';
		}else{
			$sql = $this->mysqli->prepare("SELECT * FROM escuela WHERE codigoEscuela = ?");
			$sql->bind_param("i", $this->codigoEscuela);
			$sql->execute();

			$resultado = $sql->get_result();
			  
			if(!$resultado){
				return 'No se ha podido conectar con la BD';
			}else if($resultado->num_rows == 0){
				return 'No existe la escuela';
			}else{
				$fila = $resultado->fetch_row();
			
				$this->_setNombreEscuela($fila[1]);
			}
		}
	}


	function ADD(){//Para añadir a la BD
		$sql = $this->mysqli->prepare("INSERT INTO escuela (nombreEscuela) VALUES (?)");
		$sql->bind_param("s", $this->nombreEscuela);
		
		$resultado = $sql->execute();

		if(!$resultado){
			return 'Ha fallado el insertar la escuela';
		}else{
			return 'Inserción correcta';
		}
	}
  
	function EDIT(){//Para editar de la BD
		if(($this->codigoEscuela == '')){
			return 'Escuela vacia, introduzca una escuela';
		}else{
			$sql = $this->mysqli->prepare("SELECT * FROM escuela WHERE codigoEscuela = ?");
			$sql->bind_param("i", $this->codigoEscuela);
			$sql->execute();
		  
			$resultado = $sql->get_result();
		  
			if(!$resultado){
				return 'No se ha podido conectar con la BD';
			}else if($resultado->num_rows == 1){
				$sql = $this->mysqli->prepare("UPDATE escuela SET nombreEscuela = ? WHERE codigoEscuela = ?");
				$sql->bind_param("si", $this->nombreEscuela, $this->codigoEscuela);
				
				$resultado = $sql->execute();
			}else{
				return 'Escuela no existe en la base de datos';
			}
			
			if(!$resultado){
				return 'Ha fallado la actualización de escuela';
			}else{
				return 'Modificación correcta';
			}
		}
	}


  
	function SEARCH(){
		$sql = $this->mysqli->prepare("SELECT * FROM escuela WHERE ((codigoEscuela LIKE ?) AND (nombreEscuela LIKE ?))");
		$likeCodigoEscuela = "%" . $this->_getCodigoEscuela() . "%";
		$likeNombreEscuela = "%" . $this->_getNombreEscuela() . "%";
		
		$sql->bind_param("ss", $likeCodigoEscuela, $likeNombreEscuela);
		$sql->execute();
		
		$resultado = $sql->get_result();
		
		if(!$resultado || $resultado->num_rows == 0){
			return 'No se ha encontrado ningun dato';
		}else{
			return $resultado;
		}
	}
  
	function DELETE(){//Para eliminar de la BD
		$sql = $this->mysqli->prepare("SELECT * FROM escuela WHERE codigoEscuela = ?");
		$sql->bind_param("i", $this->codigoEscuela);
		$sql->execute();
		
		$resultado = $sql->get_result();
		
		if(!$resultado){
			return 'No se ha podido conectar con la BD';
		}else if($resultado->num_rows == 0){
			return 'No se ha encontrado la escuela';
		}else{
			$sql = $this->mysqli->prepare("DELETE FROM escuela WHERE codigoEscuela = ?");
			$sql->bind_param("i", $this->codigoEscuela);
			$resultado = $sql->execute();
			
			if(!$resultado){
				return 'Fallo al eliminar la tupla';
			}else{
				return 'Escuela eliminada correctamente';
			}
		}
	}
  
	function SHOWCURRENT(){//Para mostrar de la base de datos
		$sql = $this->mysqli->prepare("SELECT * FROM escuela WHERE codigoEscuela = ?");
		$sql->bind_param("i", $this->codigoEscuela);
		$sql->execute();
		
		$resultado = $sql->get_result();
		
		if(!$resultado){
			return 'No se ha podido conectar con la BD';
		}else if($resultado->num_rows == 0){
			return 'No existe la escuela';
		}else{
			return $resultado;
		}
	}
	
	function SHOWALL(){
		$sql = "SELECT * FROM escuela";
		
		$resultado = $this->mysqli->query($sql);
		
		if(!$resultado){
			return 'No se ha podido conectar con la BD';
		}else{
			return $resultado;
		}
	}
}
?>