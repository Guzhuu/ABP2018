<?php
/* 
	Modelo de la clase Reserva
*/
class Reserva{
	//Atributos
	var $Reserva;
	var $codigoPistayHorario;
	var $DNI_Deportista;
	var $mysqli;
	
	function __construct($Reserva, $codigoPistayHorario, $DNI_Deportista){
		//Asignaciones
		$this->_setReserva($Reserva);
		$this->_setCodigoPistayHorario($codigoPistayHorario);
		$this->_setDNI($DNI_Deportista);
		
		include_once '../Functions/ConectarBD.php'; //Actualizar
		$this->mysqli = ConectarBD();
	}

	function _setReserva($Reserva){
		$this->Reserva = $Reserva;
	}
	
	function _setCodigoPistayHorario($codigoPistayHorario){
		$this->codigoPistayHorario = $codigoPistayHorario;
	}
	
	function _setDNI($DNI){
		$this->DNI_Deportista = $DNI;
	}
	
	function _getReserva(){
		return $this->Reserva;
	}
	
	function _getCodigoPistayHorario(){
		return $this->codigoPistayHorario;
	}
	
	function _getDNI(){
		return $this->DNI_Deportista;
	}
	
	function _getDatosGuardados(){//Para recuperar de la base de datos
		if(($this->Reserva == '')){
			return 'Reserva vacia, introduzca una reserva';
		}else{
			$sql = $this->mysqli->prepare("SELECT * FROM reserva WHERE Reserva = ?");
			$sql->bind_param("i", $this->Reserva);
			$sql->execute();
			
			$resultado = $sql->get_result();
			
			if(!$resultado){
				return 'No se ha podido conectar con la BD';
			}else if($resultado->num_rows == 0){
				return 'No existe la reserva';
			}else{
				$fila = $resultado->fetch_row();
				
				$this->_setCodigoPistayHorario($fila[1]);
				if($this->DNI_Deportista !== null || $this->DNI_Deportista === null || $this->DNI_Deportista === ''){
					$this->_setDNI($fila[2]);
				}
			}
		}
	}
	
	
	function ADD(){//Para añadir a la BD
		$sql = $this->mysqli->prepare("INSERT INTO reserva (codigoPistayHorario, DNI_Deportista) VALUES (?,?)");
		$sql->bind_param("is", $this->codigoPistayHorario, $this->DNI_Deportista);
		$resultado = $sql->execute();
	
		if(!$resultado){
			return 'Ha fallado el hacer la reserva';
		}else{
			return 'Reserva creada';
		}
	}
	
	function RESERVAR(){
		$sql = $this->mysqli->prepare("SELECT COUNT(*) FROM reserva WHERE DNI_Deportista = ?");
		$sql->bind_param("s", $this->DNI_Deportista);
		$sql->execute();
	
		$resultado = $sql->get_result();
		
		if(!$resultado){
			return 'Ha fallado el hacer la reserva';
		}else if($resultado->fetch_row()[0] >= 5){
			return 'Has superado el límite de reservas, cancela alguna para poder hacer otra';
		}else{
			return $this->ADD();
		}
	}
	
	function EDIT(){//Para editar de la BD
		if(($this->Reserva == '')){
			return 'Reserva vacia, introduzca una reserva';
		}else{
			$sql = $this->mysqli->prepare("SELECT * FROM reserva WHERE Reserva = ?");
			$sql->bind_param("i", $this->Reserva);
			$sql->execute();
			
			$resultado = $sql->get_result();
			
			if(!$resultado){
				return 'No se ha podido conectar con la BD';
			}else if($resultado->num_rows == 1){
				$sql = $this->mysqli->prepare("UPDATE reserva SET codigoPistayHorario = ?, DNI_Deportista = ?  WHERE Reserva = ?");
				$sql->bind_param("isi", $this->codigoPistayHorario, $this->DNI_Deportista, $this->Reserva);
				$resultado = $sql->execute();
				
				if(!$resultado){
					return 'Ha fallado la actualización de la reserva';
				}else{
					return 'Modificado correcto';
				}
			}else{
				return 'La reserva no existe en la base de datos';
			}
		}
	}
	
	function SEARCH(){
		$sql = $this->mysqli->prepare("SELECT * FROM reserva WHERE ((Reserva LIKE ?) AND (codigoPistayHorario LIKE ?) AND (DNI_Deportista LIKE ?))");
		$likeReserva = "%" . $this->_getReserva() . "%";
		$likeCodigoPistayHorario = "%" . $this->_getCodigoPistayHorario() . "%";
		$likeDNI_Deportista = "%" . $this->_getDNI() . "%";
		$sql->bind_param("sss", $likeReserva, $likeCodigoPistayHorario, $likeDNI_Deportista); //Puede dar fallo facil
		$sql->execute();
		
		$resultado = $sql->get_result();
		
		if(!$resultado || $resultado->num_rows == 0){
			return 'No se ha encontrado ningun dato';
		}else{
			return $resultado;
		}
	}
	
	function DELETE(){//Para eliminar de la BD
		$sql = $this->mysqli->prepare("SELECT * FROM reserva WHERE Reserva = ?");
		$sql->bind_param("i", $this->Reserva);
		$sql->execute();
		
		$resultado = $sql->get_result();
		
		if(!$resultado){
			return 'No se ha podido conectar con la BD';
		}else if($resultado->num_rows == 0){
			return 'No se ha encontrado la reserva';
		}else{
			$sql = $this->mysqli->prepare("DELETE FROM reserva WHERE Reserva = ?");
			$sql->bind_param("i", $this->Reserva);
			$resultado = $sql->execute();
		
			if(!$resultado){
				return 'Fallo al eliminar la tupla';
			}else{
				return 'Reserva eliminada correctamente';
			}
		}
	}
	
	function CANCELARRESERVA(){
		$sql = $this->mysqli->prepare("SELECT reserva.reserva, horario.HoraInicio FROM reserva, pista_tiene_horario, horario WHERE Reserva = ? AND DNI_Deportista = ? 
										AND reserva.codigoPistayHorario = pista_tiene_horario.codigoPistayHorario AND pista_tiene_horario.Horario_Horario = Horario.Horario");
		$sql->bind_param("is", $this->Reserva, $this->DNI_Deportista);
		$sql->execute();
		
		$resultado = $sql->get_result();
		
		if(!$resultado){
			return 'No se ha podido conectar con la BD';
		}else if($resultado->num_rows == 0){
			return 'Error al cancelar la reserva';
		}else{
			$now = time();
			$target = strtotime($resultado->fetch_row()[1]);
			$diff = $now - $now;
			if ( $diff > (12*60*60) ) {
				return 'Solo se puede cancelar una reserva con 12 horas de antelación';
			}else{
				$sql = $this->mysqli->prepare("DELETE FROM reserva WHERE Reserva = ? AND DNI_Deportista = ?");
				$sql->bind_param("is", $this->Reserva, $this->DNI_Deportista);
				$resultado = $sql->execute();
			
				if(!$resultado){
					return 'Fallo al cancelar la reserva';
				}else{
					return 'Reserva cancelada correctamente';
				}
			}
		}
	}
	
	function SHOWCURRENT(){//Para mostrar de la base de datos
		$sql = $this->mysqli->prepare("SELECT * FROM reserva WHERE Reserva = ?");
		$sql->bind_param("i", $this->Reserva);
		$sql->execute();
		
		$resultado = $sql->get_result();
		
		if(!$resultado){
			return 'No se ha podido conectar con la BD';
		}else if($resultado->num_rows == 0){
			return 'No existe la reserva';
		}else{
			return $resultado;
		}
	}
	
	function SHOWALL(){//Para mostrar la BD
		$sql = "SELECT 	reserva.Reserva, pista_tiene_horario.codigoPistayHorario, pista_tiene_horario.Pista_codigoPista, pista.nombre, pista_tiene_horario.Horario_Horario, horario.HoraInicio, 
							horario.HoraFin 
						FROM reserva, pista_tiene_horario, horario, pista 
						WHERE reserva.codigoPistayHorario = pista_tiene_horario.codigoPistayHorario 
							AND pista_tiene_horario.Pista_codigoPista = pista.codigoPista 
							AND pista_tiene_horario.Horario_Horario = horario.Horario;";
		
		$resultado = $this->mysqli->query($sql);
		
		if(!$resultado){
			return 'No se ha podido conectar con la BD';
		}else{
			return $resultado;
		}
	}
	
	function RESERVAS(){
		$sql = $this->mysqli->prepare("SELECT * FROM reserva");
		$sql->execute();
		
		$resultado = $sql->get_result();
		
		if(!$resultado){
			return array();
		}else if($resultado->num_rows == 0){
			return array();
		}else{
			return $resultado->fetch_all();
		}
	}
	
	function RESERVASDE(){
		$sql = $this->mysqli->prepare("SELECT * FROM reserva WHERE DNI_Deportista = ? AND reserva.Reserva NOT IN (SELECT clase.Reserva_Reserva FROM clase WHERE DNI_Deportista = ?)");
		$sql->bind_param("ss", $this->DNI_Deportista, $this->DNI_Deportista);
		$sql->execute();
		
		$resultado = $sql->get_result();
		
		if(!$resultado){
			return array();
		}else if($resultado->num_rows == 0){
			return array();
		}else{
			return $resultado->fetch_all();
		}
	}
	
	function VERRESERVAS(){
		$sql = $this->mysqli->prepare("	SELECT reserva.Reserva, reserva.DNI_Deportista, horario.HoraInicio, horario.HoraFin, pista.nombre FROM reserva, horario, pista, pista_tiene_horario
										WHERE reserva.DNI_Deportista = ? AND reserva.codigoPistayHorario = pista_tiene_horario.codigoPistayHorario 
												AND pista_tiene_horario.Horario_Horario = horario.Horario AND pista_tiene_horario.Pista_codigoPista = pista.codigoPista");
		$sql->bind_param("s", $this->DNI_Deportista);
		$sql->execute();
		
		$resultado = $sql->get_result();
		
		if(!$resultado){
			return 'No se ha podido conectar con la BD';
		}else{
			return $resultado;
		}
	}
}
?>