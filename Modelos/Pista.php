<?php
/* 
	Modelo de la clase pista
*/
class Pista{
	//Atributos
	var $codigoPista;
	var $nombre;
	var $mysqli;
	
	function __construct($codigoPista, $nombre){
		//Asignaciones
		$this->_setCodigoPista($codigoPista);
		$this->_setNombre($nombre);
		
		include_once '../Functions/ConectarBD.php'; //Actualizar
		$this->mysqli = ConectarBD();
	}

	function _setCodigoPista($codigoPista){
		$this->codigoPista = $codigoPista;
	}
	
	function _setNombre($nombre){
		$this->nombre = $nombre;
	}
	
	
	function _getCodigoPista(){
		return $this->codigoPista;
	}
	
	function _getNombre(){
		return $this->nombre;
	}
	
	function _getDatosGuardados(){//Para recuperar de la base de datos
		if(($this->codigoPista == '')){
			return 'Codigo de pista vacio, introduzca un codigo de pista';
		}else{
			$sql = $this->mysqli->prepare("SELECT * FROM pista WHERE codigoPista = ?");
			$sql->bind_param("s", $this->codigoPista);
			$sql->execute();
			
			$resultado = $sql->get_result();
			
			if(!$resultado){
				return 'No se ha podido conectar con la BD';
			}else if($resultado->num_rows == 0){
				return 'No existe el codigoPista';
			}else{
				$fila = $resultado->fetch_row();
				
				$this->_setNombre($fila[1]);
			}
		}
	}
	
	
	function ADD(){//Para añadir a la BD
		$sql = $this->mysqli->prepare("INSERT INTO pista (nombre) VALUES (?)");
		$sql->bind_param("s", $this->nombre);
		$resultado = $sql->execute();
	
		if(!$resultado){
			return 'Ha fallado el insertar la pista';
		}else{
			return 'Inserción correcta';
		}
	}
	
	function EDIT(){//Para editar de la BD
		if(($this->codigoPista == '')){
			return 'Codigo de pista vacio, introduzca un codigo de pista';
		}else{
			$sql = $this->mysqli->prepare("SELECT * FROM pista WHERE codigoPista = ?");
			$sql->bind_param("i", $this->codigoPista);
			$sql->execute();
			
			$resultado = $sql->get_result();
			
			if(!$resultado){
				return 'No se ha podido conectar con la BD';
			}else if($resultado->num_rows == 1){
				$sql = $this->mysqli->prepare("UPDATE pista SET nombre = ? WHERE codigoPista = ?");
				$sql->bind_param("si", $this->nombre, $this->codigoPista);
				$resultado = $sql->execute();
				
				if(!$resultado){
					return 'Ha fallado la actualización de la pista';
				}else{
					return 'Modificado correcto';
				}
			}else{
				return 'Codigo de pista no existe en la base de datos';
			}
		}
	}
	
	function SEARCH(){
		$sql = $this->mysqli->prepare("SELECT * FROM pista WHERE ((codigoPista LIKE ?) AND (nombre LIKE ?))");
		$likeCodigoPista = "%" . $this->_getCodigoPista() . "%";
		$likeNombre = "%" . $this->_getNombre() . "%";
		$sql->bind_param("ss", $likeCodigoPista, $likeNombre); //Puede dar fallo facil
		$sql->execute();
		
		$resultado = $sql->get_result();
		
		if(!$resultado || $resultado->num_rows == 0){
			return 'No se ha encontrado ningun dato';
		}else{
			return $resultado;
		}
	}
	
	function DELETE(){//Para eliminar de la BD
		$sql = $this->mysqli->prepare("SELECT * FROM pista WHERE codigoPista = ?");
		$sql->bind_param("i", $this->codigoPista);
		$sql->execute();
		
		$resultado = $sql->get_result();
		
		if(!$resultado){
			return 'No se ha podido conectar con la BD';
		}else if($resultado->num_rows == 0){
			return 'No se ha encontrado la pista';
		}else{
			$sql = $this->mysqli->prepare("DELETE FROM pista WHERE codigoPista = ?");
			$sql->bind_param("i", $this->codigoPista);
			$resultado = $sql->execute();
		
			if(!$resultado){
				return 'Fallo al eliminar la tupla';
			}else{
				return 'Pista eliminada correctamente';
			}
		}
	}
	
	function SHOWCURRENT(){//Para mostrar de la base de datos
		$sql = $this->mysqli->prepare("SELECT * FROM pista WHERE codigoPista = ?");
		$sql->bind_param("i", $this->codigoPista);
		$sql->execute();
		
		$resultado = $sql->get_result();
		
		if(!$resultado){
			return 'No se ha podido conectar con la BD';
		}else if($resultado->num_rows == 0){
			return 'No existe el codigo de pista';
		}else{
			return $resultado;
		}
	}
	
	function SHOWCURRENT_AND_HORARIO(){//Para mostrar de la base de datos
		$sql = $this->mysqli->prepare("SELECT * FROM pista, pista_tiene_horario, horario
										WHERE ((pista.codigoPista = ?) AND (pista.codigoPista = pista_tiene_horario.Pista_codigoPista)
										AND (pista_tiene_horario.Horario_Horario = horario.Horario))");
		$sql->bind_param("i", $this->codigoPista);
		$sql->execute();
		
		$resultado = $sql->get_result();
		
		if(!$resultado){
			return 'No se ha podido conectar con la BD';
		}else if($resultado->num_rows == 0){
			return 'No existe el codigo de pista';
		}else{
			return $resultado;
		}
	}
	
	function SHOWCURRENT_AND_HORARIO_LIBRE(){//A implementar
		$sql = $this->mysqli->prepare("SELECT pista_tiene_horario.codigoPistayHorario, pista_tiene_horario.Pista_codigoPista, pista.nombre, pista_tiene_horario.Horario_Horario, horario.HoraInicio, horario.HoraFin 
										FROM pista_tiene_horario, pista, horario 
										WHERE pista.codigoPista = ? 
											AND pista_tiene_horario.codigoPistayHorario NOT IN(SELECT reserva.codigoPistayHorario FROM reserva) 
											AND pista_tiene_horario.Pista_codigoPista = pista.codigoPista 
											AND pista_tiene_horario.Horario_Horario = horario.Horario");
		$sql->bind_param("i", $this->codigoPista);
		$sql->execute();
		
		$resultado = $sql->get_result();
		
		if(!$resultado){
			return 'No se ha podido conectar con la BD';
		}else if($resultado->num_rows == 0){
			return 'No existe el codigo de pista';
		}else{
			return $resultado;
		}
	}
	
	function SHOWCURRENT_AND_HORARIO_OCUPADO(){//A implementar
		$sql = $this->mysqli->prepare("SELECT * FROM pista, pista_tiene_horario, reserva, horario
										WHERE ((pista.codigoPista = 1) AND (pista.codigoPista = pista_tiene_horario.Pista_codigoPista) 
										AND (pista_tiene_horario.codigoPistayHorario = reserva.codigoPistayHorario) AND (pista_tiene_horario.Horario_Horario = horario.Horario))");
		$sql->bind_param("i", $this->codigoPista);
		$sql->execute();
		
		$resultado = $sql->get_result();
		
		if(!$resultado){
			return 'No se ha podido conectar con la BD';
		}else if($resultado->num_rows == 0){
			return 'No existe el codigo de pista';
		}else{
			return $resultado;
		}
	}
	
	function SHOWALL(){//Para mostrar la BD
		$sql = "SELECT * FROM pista";
		
		$resultado = $this->mysqli->query($sql);
		
		if(!$resultado){
			return 'No se ha podido conectar con la BD';
		}else{
			return $resultado;
		}
	}
	
	function SHOWALL_AND_HORARIO(){
		$sql = "SELECT * 	FROM pista, pista_tiene_horario, horario
				WHERE pista.codigoPista = pista_tiene_horario.Pista_codigoPista AND pista_tiene_horario.Horario_Horario = horario.Horario";
		
		$resultado = $this->mysqli->query($sql);
		
		if(!$resultado){
			return 'No se ha podido conectar con la BD';
		}else{
			return $resultado;
		}
	}
	
	function SHOWALL_AND_HORARIOS_LIBRES(){
		$sql = ("SELECT pista_tiene_horario.codigoPistayHorario, pista_tiene_horario.Pista_codigoPista, pista.nombre, pista_tiene_horario.Horario_Horario, horario.HoraInicio, horario.HoraFin 
						FROM pista_tiene_horario, pista, horario 
						WHERE pista_tiene_horario.codigoPistayHorario NOT IN(SELECT reserva.codigoPistayHorario FROM reserva) 
							AND pista_tiene_horario.Pista_codigoPista = pista.codigoPista 
							AND pista_tiene_horario.Horario_Horario = horario.Horario 
							AND horario.HoraInicio >= CURDATE()
						ORDER BY pista_tiene_horario.Pista_codigoPista;");
		
		$resultado = $this->mysqli->query($sql);
		
		if(!$resultado){
			return 'No se ha podido conectar con la BD';
		}else{
			return $resultado;
		}
	}
	
	function SHOWALL_AND_HORARIO_OCUPADAS(){
		$sql = ("SELECT * FROM pista, pista_tiene_horario, reserva, horario
				WHERE ((pista.codigoPista = pista_tiene_horario.Pista_codigoPista) 
				AND (pista_tiene_horario.codigoPistayHorario = reserva.codigoPistayHorario) AND (pista_tiene_horario.Horario_Horario = horario.Horario))");
		
		$resultado = $this->mysqli->query($sql);
		
		if(!$resultado){
			return 'No se ha podido conectar con la BD';
		}else{
			return $resultado;
		}
	}
}
?>