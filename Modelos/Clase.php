<?php


// file: model/ExerciseMapper.php
//require_once(__DIR__."/../core/PDOConnection.php");

//require_once(__DIR__."/../model/User.php");
//require_once(__DIR__."/../model/Ejercicio.php");



class Clase{
	var $Clase;
	var $Reserva_Reserva;
	var $codigoEscuela;
	var $Entrenador;
	var $Curso;
	var $mysqli;

	function __construct($Clase, $Reserva_Reserva, $codigoEscuela, $Entrenador, $Curso){
  		$this->Clase = $Clase;
  		$this->Reserva_Reserva = $Reserva_Reserva;
  		$this->codigoEscuela = $codigoEscuela;
  		$this->Entrenador = $Entrenador;
		$this->Curso = $Curso;
		include_once '../Functions/ConectarBD.php'; //Actualizar
		$this->mysqli = ConectarBD();
	}

	public function _getClase(){
		return $this->Clase;
	}

	public function _getReserva(){
		return $this->Reserva_Reserva;
	}
  
	public function _getEscuela(){
		return $this->codigoEscuela;
	}

	public function _getEntrenador(){
		return $this->Entrenador;
	}
	
	public function _getCurso(){
		return $this->Curso;
	}


	public function _setClase($Clase){
		$this->Clase = $Clase;
	}

	public function _setReserva($Reserva){
		$this->Reserva_Reserva = $Reserva;
	}
  
	public function _setEscuela($codigoEscuela){
		$this->codigoEscuela = $codigoEscuela;
	}

	public function _setEntrenador($Entrenador){
		$this->Entrenador = $Entrenador;
	}

	public function _setCurso($Curso){
		$this->Curso = $Curso;
	}


    function _getDatosGuardados(){//Para recuperar de la base de datos
		if(($this->_getClase() == '')){
			return 'Clase vacia, introduzca una clase';
		}else{
			$sql = $this->mysqli->prepare("SELECT * FROM clase WHERE Clase = ?");
			$sql->bind_param("i", $this->Clase);
			$sql->execute();

			$resultado = $sql->get_result();
			  
			if(!$resultado){
				return 'No se ha podido conectar con la BD';
			}else if($resultado->num_rows == 0){
				return 'No existe la clase';
			}else{
				$fila = $resultado->fetch_row();
			
				$this->_setReserva($fila[1]);
				$this->_setEscuela($fila[2]);
				$this->_setEntrenador($fila[3]);
				$this->_setCurso($fila[4]);
			}
		}
	}


	function ADD(){//Para añadir a la BD
		$sql = $this->mysqli->prepare("INSERT INTO clase (Reserva_Reserva, codigoEscuela, Entrenador, Curso) VALUES (?, ?, ?, ?)");
		$sql->bind_param("iiss", $this->Reserva_Reserva, $this->codigoEscuela, $this->Entrenador, $this->Curso);
		
		$resultado = $sql->execute();

		if(!$resultado){
			return 'Ha fallado el insertar la clase';
		}else{
			return 'Inserción correcta';
		}
	}
  
	function EDIT(){//Para editar de la BD
		if(($this->Clase == '')){
			return 'Clase vacia, introduzca una clase';
		}else{
			$sql = $this->mysqli->prepare("SELECT * FROM clase WHERE Clase = ?");
			$sql->bind_param("i", $this->Clase);
			$sql->execute();
		  
			$resultado = $sql->get_result();
		  
			if(!$resultado){
				return 'No se ha podido conectar con la BD';
			}else if($resultado->num_rows == 1){
				$sql = $this->mysqli->prepare("UPDATE clase SET Reserva_Reserva = ?, codigoEscuela = ?, Entrenador = ?, Curso = ? WHERE Clase = ?");
				$sql->bind_param("iiis", $this->Reserva_Reserva, $this->codigoEscuela, $this->Entrenador, $this->Curso, $this->Clase);
				
				$resultado = $sql->execute();
			}else{
				return 'Clase no existe en la base de datos';
			}
			
			if(!$resultado){
				return 'Ha fallado la actualización de clase';
			}else{
				return 'Modificación correcta';
			}
		}
	}


  
	function SEARCH(){
		$sql = $this->mysqli->prepare("SELECT * FROM clase WHERE ((Clase LIKE ?) AND (Reserva_Reserva LIKE ?) AND (codigoEscuela LIKE ?) AND (Entrenador LIKE ?) AND (Curso LIKE ?))");
		$likeClase = "%" . $this->_getClase() . "%";
		$likeReserva = "%" . $this->_getReserva() . "%";
		$likeEscuela = "%" . $this->_getEscuela() . "%";
		$likeEntrenador = "%" . $this->_getEntrenador() . "%";
		$likeCurso = "%" . $this->_getCurso() . "%";
		
		$sql->bind_param("ssss", $likeClase, $likeReserva, $likeEscuela, $likeEntrenador, $likeCurso);
		$sql->execute();
		
		$resultado = $sql->get_result();
		
		if(!$resultado || $resultado->num_rows == 0){
			return 'No se ha encontrado ningun dato';
		}else{
			return $resultado;
		}
	}
  
	function DELETE(){//Para eliminar de la BD
		$sql = $this->mysqli->prepare("SELECT * FROM clase WHERE Clase = ?");
		$sql->bind_param("i", $this->Clase);
		$sql->execute();
		
		$resultado = $sql->get_result();
		
		if(!$resultado){
			return 'No se ha podido conectar con la BD';
		}else if($resultado->num_rows == 0){
			return 'No se ha encontrado clase';
		}else{
			$sql = $this->mysqli->prepare("DELETE FROM clase WHERE Clase = ?");
			$sql->bind_param("i", $this->Clase);
			$resultado = $sql->execute();
			
			if(!$resultado){
				return 'Fallo al eliminar la tupla';
			}else{
				return 'Clase eliminada correctamente';
			}
		}
	}
	
	function DETALLES(){
		$sql = $this->mysqli->prepare("	SELECT 	clase.Clase, escuela.codigoEscuela, escuela.nombreEscuela, clase.Entrenador, clase.Reserva_Reserva, clase.Curso,
												horario.Horario, horario.HoraInicio, horario.HoraFin, pista.codigoPista, pista.nombre 
										FROM clase, escuela, reserva, pista_tiene_horario, horario, pista 
										WHERE 	clase.Clase = ? AND clase.Reserva_Reserva = reserva.Reserva AND 
												reserva.codigoPistayHorario = pista_tiene_horario.codigoPistayHorario AND pista_tiene_horario.Horario_Horario = horario.Horario 
												AND pista_tiene_horario.Pista_codigoPista = pista.codigoPista AND clase.codigoEscuela = escuela.codigoEscuela
										ORDER BY Curso");
		$sql->bind_param("i", $this->Clase);
		$sql->execute();
		
		$resultado = $sql->get_result();
		
		if(!$resultado){
			return 'No se ha podido conectar con la BD';
		}else if($resultado->num_rows == 0){
			return 'No se ha encontrado clase';
		}else{
			return $resultado;
		}
	}
	
	/**Al borrar la reserva, se hace el cascade de la clase. La reserva debería ser única para una sola clase o reserva privada**/
	function ANULARCLASE(){
		$sql = $this->mysqli->prepare("SELECT * FROM clase WHERE Clase = ?");
		$sql->bind_param("i", $this->Clase);
		$sql->execute();
		
		$resultado = $sql->get_result();
		
		if(!$resultado){
			return 'No se ha podido conectar con la BD';
		}else if($resultado->num_rows == 0){
			return 'No se ha encontrado clase';
		}else{
			$sql = $this->mysqli->prepare("DELETE FROM Reserva WHERE Reserva = ?");
			$sql->bind_param("i", $this->Reserva_Reserva);
			$resultado = $sql->execute();
			
			if(!$resultado){
				return 'Fallo al anular la clase';
			}else{
				return 'Clase anulada correctamente';
			}
		}
	}
	
	function CURSO(){
		$sql = $this->mysqli->prepare("SELECT * FROM clase WHERE Curso = ?");
		$sql->bind_param("s", $this->Curso);
		$sql->execute();
		
		$resultado = $sql->get_result();
		
		if(!$resultado){
			return 'No se ha podido conectar con la BD';
		}else if($resultado->num_rows == 0){
			return 'No se ha encontrado el curso';
		}else{
			return $resultado;
		}
	}
	
	function ANULARCURSO(){
		$sql = $this->mysqli->prepare("SELECT * FROM clase WHERE Curso = ?");
		$sql->bind_param("s", $this->Curso);
		$sql->execute();
		
		$resultado = $sql->get_result();
		
		$retorno = true;
		
		if(!$resultado){
			return 'No se ha podido conectar con la BD';
		}else{
			while($unaClase = $resultado->fetch_row()){
				$sql = $this->mysqli->prepare("DELETE FROM Reserva WHERE Reserva = ?");
				/**1 es la posición del field Reserva_Reserva**/
				$sql->bind_param("i", $unaClase[1]);
				if(!$sql->execute()){
					$retorno = false;
				}
			}
		}
		
		if($retorno){
			return 'Curso anulado correctamente';
		}else{
			return 'Fallo al anular el curso';
		}
	}
  
	function SHOWCURRENT(){//Para mostrar de la base de datos
		$sql = $this->mysqli->prepare("SELECT * FROM clase WHERE Clase = ?");
		$sql->bind_param("i", $this->Clase);
		$sql->execute();
		
		$resultado = $sql->get_result();
		
		if(!$resultado){
			return 'No se ha podido conectar con la BD';
		}else if($resultado->num_rows == 0){
			return 'No existe clase';
		}else{
			return $resultado;
		}
	}
	
	function SHOWALL(){
		$sql = "SELECT * FROM clase ORDER BY Curso";
		
		$resultado = $this->mysqli->query($sql);
		
		if(!$resultado){
			return 'No se ha podido conectar con la BD';
		}else{
			return $resultado;
		}
	}
	
	function SHOWALLFROM(){
		/* EL ENTRENADOR DEBE PODER: 
			* Anular clase (FALTA VISTA)
			* Crear clases particulares (hora concreta hablarlo con alumno) (FALTA VISTA)
			* Crear clases grupales (FALTA VISTA)
			* Anular curso (FALTA VISTA)
			* Ver alumnos apuntados, por si acaso no va nadie (HACER BOTON Y POCO MÁS)
			* Editar horas, qutiando la reserva si se da el caso (lo mismo en anular) (FALTA VISTA)
		*/
		$sql = $this->mysqli->prepare("	SELECT 	clase.Clase, escuela.codigoEscuela, escuela.nombreEscuela, clase.Entrenador, clase.Reserva_Reserva, clase.Curso,
												horario.Horario, horario.HoraInicio, horario.HoraFin, pista.codigoPista, pista.nombre 
										FROM clase, escuela, reserva, pista_tiene_horario, horario, pista 
										WHERE 	clase.Entrenador = ? AND clase.Reserva_Reserva = reserva.Reserva AND 
												reserva.codigoPistayHorario = pista_tiene_horario.codigoPistayHorario AND pista_tiene_horario.Horario_Horario = horario.Horario 
												AND pista_tiene_horario.Pista_codigoPista = pista.codigoPista AND clase.codigoEscuela = escuela.codigoEscuela
										ORDER BY Curso");
		$sql->bind_param("s", $this->Entrenador);
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