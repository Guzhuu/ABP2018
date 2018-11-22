<?php
/* 
	Modelo de la clase Horario
*/
class Horario{
	//Atributos
	var $Horario;
	var $HoraInicio;
	var $HoraFin;
	var $mysqli;
	
	function __construct($Horario, $HoraInicio, $HoraFin){
		//Asignaciones
		$this->_setHorario($Horario);
		$this->_setHoraInicio($HoraInicio);
		$this->_setHoraFin($HoraFin);
		
		include_once '../Functions/ConectarBD.php'; //Actualizar
		$this->mysqli = ConectarBD();
	}

	function _setHorario($Horario){
		$this->Horario = $Horario;
	}

	function _setHoraInicio($HoraInicio){
		$this->HoraInicio = $HoraInicio;
	}

	function _setHoraFin($HoraFin){
		$this->HoraFin = $HoraFin;
	}

	function _getHorario(){
		return $this->Horario;
	}

	function _getHoraInicio(){
		return $this->HoraInicio;
	}

	function _getHoraFin(){
		return $this->HoraFin;
	}
	
	function _getDatosGuardados(){//Para recuperar de la base de datos
		if(($this->_getHorario() == '')){
			return 'Horario vacio, introduzca un horario';
		}else{
			$sql = $this->mysqli->prepare("SELECT * FROM horario WHERE Horario = ?");
			$sql->bind_param("i", $this->Horario);
			$sql->execute();
			
			$resultado = $sql->get_result();
			
			if(!$resultado){
				return 'No se ha podido conectar con la BD';
			}else if($resultado->num_rows == 0){
				return 'No existe el Horario';
			}else{
				$fila = $resultado->fetch_row();
				
				$this->_setHoraInicio($fila[1]);
				$this->_setHoraFin($fila[2]);
			}
		}
	}
	
	
	function ADD(){//Para añadir a la BD
		$sql = $this->mysqli->prepare("INSERT INTO horario (HoraInicio, HoraFin) VALUES (?, ?)");
		$sql->bind_param("ss", $this->HoraInicio, $this->HoraFin);
		$resultado = $sql->execute();
	
		if(!$resultado){
			return 'Ha fallado el insertar el horario';
		}else{
			return 'Inserción correcta';
		}
	}
	
	function EDIT(){//Para editar de la BD
		if(($this->Horario == '')){
			return 'Horario vacio, introduzca un Horario';
		}else{
			$sql = $this->mysqli->prepare("SELECT * FROM horario WHERE Horario = ?");
			$sql->bind_param("i", $this->Horario);
			$sql->execute();
			
			$resultado = $sql->get_result();
			
			if(!$resultado){
				return 'No se ha podido conectar con la BD';
			}else if($resultado->num_rows == 1){
				$sql = $this->mysqli->prepare("UPDATE horario SET HoraInicio = ?, HoraFin = ? WHERE Horario = ?");
				$sql->bind_param("sss", $this->HoraInicio, $this->HoraFin, $this->Horario);
				$resultado = $sql->execute();
				
				if(!$resultado){
					return 'Ha fallado la actualización de la horario';
				}else{
					return 'Modificado correcto';
				}
			}else{
				return 'Horario no existe en la base de datos';
			}
		}
	}
	
	function SEARCH(){
		$sql = $this->mysqli->prepare("SELECT * FROM horario WHERE ((Horario LIKE ?) AND (HoraInicio LIKE ?) AND (HoraFin LIKE ?))"); //No funciona
		$likeHorario = "%" . $this->_getHorario() . "%";
		$likeHoraInicio = "%" . $this->_getHoraInicio() . "%";
		$likeHoraFin = "%" . $this->_getHoraFin() . "%";
		$sql->bind_param("sss", $likeHorario, $likeHoraInicio, $likeHoraFin); //Puede dar fallo facil
		$sql->execute();
		
		$resultado = $sql->get_result();
		
		if(!$resultado || $resultado->num_rows == 0){
			return 'No se ha encontrado ningun dato';
		}else{
			return $resultado;
		}
	}
	
	function DELETE(){//Para eliminar de la BD
		$sql = $this->mysqli->prepare("SELECT * FROM horario WHERE Horario = ?");
		$sql->bind_param("i", $this->Horario);
		$sql->execute();
		
		$resultado = $sql->get_result();
		
		if(!$resultado){
			return 'No se ha podido conectar con la BD';
		}else if($resultado->num_rows == 0){
			return 'No se ha encontrado el horario';
		}else{
			$sql = $this->mysqli->prepare("DELETE FROM horario WHERE Horario = ?");
			$sql->bind_param("i", $this->Horario);
			$resultado = $sql->execute();
		
			if(!$resultado){
				return 'Fallo al eliminar la tupla';
			}else{
				return 'Horario eliminado correctamente';
			}
		}
	}
	
	function SHOWCURRENT(){//Para mostrar de la base de datos
		$sql = $this->mysqli->prepare("SELECT * FROM horario WHERE Horario = ?");
		$sql->bind_param("i", $this->Horario);
		$sql->execute();
		
		$resultado = $sql->get_result();
		
		if(!$resultado){
			return 'No se ha podido conectar con la BD';
		}else if($resultado->num_rows == 0){
			return 'No existe el Horario';
		}else{
			return $resultado;
		}
	}
	
	function SHOWALL(){//Para mostrar la BD
		$sql = "SELECT * FROM horario";
		
		$resultado = $this->mysqli->query($sql);
		
		if(!$resultado){
			return 'No se ha podido conectar con la BD';
		}else{
			return $resultado;
		}
	}
}
?>