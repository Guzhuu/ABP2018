<?php
/* 
	Modelo de la clase pista_tiene_horario
*/
class pista_tiene_horario{
	//Atributos
	var $codigoPistayHorario;
	var $Pista_codigoPista;
	var $Horario_Horario;
	var $mysqli;
	
	function __construct($codigoPistayHorario, $Pista_codigoPista, $Horario_Horario){
		//Asignaciones
		$this->_setCodigoPistayHorario($codigoPistayHorario);
		$this->_setPista($Pista_codigoPista);
		$this->_setHorario($Horario_Horario);
		
		include_once '../Functions/ConectarBD.php'; //Actualizar
		$this->mysqli = ConectarBD();
	}
	
	function _setCodigoPistayHorario($codigo){
		$this->codigoPistayHorario = $codigo;
	}
	
	function _setPista($Pista_codigoPista){
		$this->Pista_codigoPista = $Pista_codigoPista;
	}
	
	function _setHorario($Horario_Horario){
		$this->Horario_Horario = $Horario_Horario;
	}
	
	function _getCodigoPistayHorario(){
		return $this->codigoPistayHorario;
	}
	
	function _getHorario(){
		return $this->Horario_Horario;
	}
	
	function _getPista(){
		return $this->Pista_codigoPista;
	}
	
	/*function _getDatosGuardados(){//Para recuperar de la base de datos
	}*/
	
	
	function ADD(){//Para añadir a la BD
		$sql = $this->mysqli->prepare("INSERT INTO pista_tiene_horario (Pista_codigoPista, Horario_Horario) VALUES (?,?)");
		$sql->bind_param("ii", $this->Pista_codigoPista, $this->Horario_Horario);
		$resultado = $sql->execute();
	
		if(!$resultado){
			return 'Ha fallado insertar el horario y pista';
		}else{
			return 'Inserción correcta';
		}
	}
	
	/*function EDIT(){//Para editar de la BD
	}*/
	
	function SEARCH(){
		$sql = $this->mysqli->prepare("SELECT * FROM pista_tiene_horario WHERE ((codigoPistayHorario LIKE ?) AND (Pista_codigoPista LIKE ?) AND (Horario_Horario LIKE ?)");
		$likeCodigo = "%" . $this->_getCodigoPistayHorario() . "%";
		$likePista = "%" . $this->_getPista() . "%";
		$likeHorario = "%" . $this->_getHorario() . "%";
		$sql->bind_param("sss", $likeCodigo, $likePista, $likeHorario); //Puede dar fallo facil
		$sql->execute();
		
		$resultado = $sql->get_result();
		
		if(!$resultado || $resultado->num_rows == 0){
			return 'No se ha encontrado ningun dato';
		}else{
			return $resultado;
		}
	}
	
	function DELETE(){//Para eliminar de la BD
		$sql = $this->mysqli->prepare("SELECT * FROM pista_tiene_horario WHERE codigoPistayHorario = ?");
		$sql->bind_param("i", $this->codigoPistayHorario);
		$sql->execute();
		
		$resultado = $sql->get_result();
		
		if(!$resultado){
			return 'No se ha podido conectar con la BD';
		}else if($resultado->num_rows == 0){
			return 'No se ha encontrado la pista y horario';
		}else{
			$sql = $this->mysqli->prepare("DELETE FROM pista_tiene_horario WHERE codigoPistayHorario = ?");
			$sql->bind_param("i", $this->codigoPistayHorario);
			$resultado = $sql->execute();
			
			if(!$resultado){
				return 'Fallo al eliminar la tupla';
			}else{
				return 'Pista y horario eliminados correctamente';
			}
		}
	}
	
	function PISTASYHORARIOS_UNSET(){
		$sql = $this->mysqli->prepare("	SELECT pista.codigoPista, pista.nombre, horario.Horario, horario.HoraInicio, horario.HoraFin 
										FROM pista, horario WHERE pista.codigoPista = ? 
											AND CONCAT(pista.codigoPista,'', horario.Horario) 
												NOT IN (SELECT CONCAT(pista_tiene_horario.Pista_codigoPista,'',pista_tiene_horario.Horario_Horario) FROM pista_tiene_horario)
											AND horario.HoraInicio >= CURDATE()
										ORDER BY pista.codigoPista, horario.Horario;");
		$sql->bind_param("i", $this->Pista_codigoPista);
		$sql->execute();
		
		$resultado = $sql->get_result();
		
		if(!$resultado){
			return 'No se ha podido conectar con la BD';
		}else if($resultado->num_rows == 0){
			return 'No se han encontrado horarios libres para la pista';
		}else{
			return $resultado;
		}
	}
	
	function PISTASYHORARIOS_SET(){
		$sql = $this->mysqli->prepare("SELECT pista_tiene_horario.codigoPistayHorario, pista_tiene_horario.Pista_codigoPista, pista.nombre, pista_tiene_horario.Horario_Horario, horario.HoraInicio, horario.HoraFin 
										FROM pista_tiene_horario, pista, horario 
										WHERE pista_tiene_horario.Pista_codigoPista = ? 
											AND pista_tiene_horario.Horario_Horario = horario.Horario 
											AND pista_tiene_horario.Pista_codigoPista = pista.codigoPista 
											AND pista_tiene_horario.codigoPistayHorario 
												NOT IN (SELECT reserva.codigoPistayHorario FROM reserva) 
										ORDER BY pista_tiene_horario.Pista_codigoPista, pista_tiene_horario.Horario_Horario");
		$sql->bind_param("i", $this->Pista_codigoPista);
		$sql->execute();
		
		$resultado = $sql->get_result();
		
		if(!$resultado){
			return 'No se ha podido conectar con la BD';
		}else if($resultado->num_rows == 0){
			return 'No se han encontrado horarios para la pista';
		}else{
			return $resultado;
		}
	}
	
	function SHOWALL(){//Para mostrar la BD
		$sql = "SELECT * FROM pista_tiene_horario";
		
		$resultado = $this->mysqli->query($sql);
		
		if(!$resultado){
			return 'No se ha podido conectar con la BD';
		}else{
			return $resultado;
		}
	}
}
?>