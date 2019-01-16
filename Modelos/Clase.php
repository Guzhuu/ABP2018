<?php
class Clase{
	var $Clase;
	var $Reserva_Reserva;
	var $codigoEscuela;
	var $Entrenador;
	var $Curso;
	var $Particulares;
	var $mysqli;

	function __construct($Clase, $Reserva_Reserva, $codigoEscuela, $Entrenador, $Curso, $Particulares){
  		$this->Clase = $Clase;
  		$this->Reserva_Reserva = $Reserva_Reserva;
  		$this->codigoEscuela = $codigoEscuela;
  		$this->Entrenador = $Entrenador;
		$this->Curso = $Curso;
		$this->Particulares = $Particulares;
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
	
	public function _getParticulares(){
		return $this->Particulares;
	}
	
	public function _getCodigoPistayHorario(){
		if(($this->_getClase() == '')){
			return '';
		}else{
			$sql = $this->mysqli->prepare("SELECT reserva.codigoPistayHorario FROM reserva WHERE Reserva = ?");
			$sql->bind_param("i", $this->Reserva_Reserva);
			$sql->execute();

			$resultado = $sql->get_result();
			  
			if(!$resultado){
				return '';
			}else if($resultado->num_rows == 0){
				return '';
			}else{
				return $resultado->fetch_row()[0];
			}
		}
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

	public function _setParticulares($Particulares){
		$this->Particulares = $Particulares;
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
				$this->_setParticulares($fila[5]);
			}
		}
	}


	function ADD(){//Para añadir a la BD
		$sql = $this->mysqli->prepare("INSERT INTO clase (Reserva_Reserva, codigoEscuela, Entrenador, Curso, Particulares) VALUES (?, ?, ?, ?, ?)");
		$sql->bind_param("iissi", $this->Reserva_Reserva, $this->codigoEscuela, $this->Entrenador, $this->Curso, $this->Particulares);
		
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
				$sql = $this->mysqli->prepare("UPDATE clase SET Reserva_Reserva = ?, codigoEscuela = ?, Entrenador = ?, Curso = ?, Particulares = ? WHERE Clase = ?");
				$sql->bind_param("iissii", $this->Reserva_Reserva, $this->codigoEscuela, $this->Entrenador, $this->Curso, $this->Particulares, $this->Clase);
				
				$resultado = $sql->execute();
			}else{
				return 'La clase no existe en la base de datos';
			}
			
			if(!$resultado){
				return 'Ha fallado la actualización de clase';
			}else{
				return 'Actualización correcta de la clase';
			}
		}
	}


  
	function SEARCH(){
		$sql = $this->mysqli->prepare("SELECT * FROM clase WHERE ((Clase LIKE ?) AND (Reserva_Reserva LIKE ?) AND (codigoEscuela LIKE ?) AND (Entrenador LIKE ?) AND (Curso LIKE ?) AND (Particulares LIKE ?))");
		$likeClase = "%" . $this->_getClase() . "%";
		$likeReserva = "%" . $this->_getReserva() . "%";
		$likeEscuela = "%" . $this->_getEscuela() . "%";
		$likeEntrenador = "%" . $this->_getEntrenador() . "%";
		$likeCurso = "%" . $this->_getCurso() . "%";
		$likeParticulares = "%" . $this->_getParticulares() . "%";
		
		$sql->bind_param("ssssss", $likeClase, $likeReserva, $likeEscuela, $likeEntrenador, $likeCurso, $likeParticulares);
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
		$sql = $this->mysqli->prepare("	SELECT 	clase.Clase, escuela.nombreEscuela, clase.Entrenador, Deportista.Nombre, Deportista.Apellidos, clase.Curso, clase.Particulares,
												horario.HoraInicio, horario.HoraFin, pista.nombre 
										FROM clase, escuela, reserva, pista_tiene_horario, horario, pista, Deportista
										WHERE 	clase.Clase = ? AND clase.Reserva_Reserva = reserva.Reserva
												AND reserva.codigoPistayHorario = pista_tiene_horario.codigoPistayHorario AND pista_tiene_horario.Horario_Horario = horario.Horario 
												AND pista_tiene_horario.Pista_codigoPista = pista.codigoPista AND clase.codigoEscuela = escuela.codigoEscuela
												AND clase.Entrenador = Deportista.DNI
										ORDER BY Curso");
		$sql->bind_param("i", $this->Clase);
		$sql->execute();
		
		$resultado = $sql->get_result();
		
		if(!$resultado){
			return 'No se ha podido conectar con la BD';
		}else if($resultado->num_rows == 0){
			return 'No se ha encontrado la clase';
		}else{
			return $resultado;
		}
	}
	
	function CLASESNOAPUNTADO($DNI){
		$sql = $this->mysqli->prepare("	SELECT 	clase.Clase as codClase, escuela.nombreEscuela, clase.Entrenador, Deportista.Nombre, Deportista.Apellidos, clase.Curso, clase.Particulares,
												horario.HoraInicio, horario.HoraFin, pista.nombre, (SELECT COUNT(*) FROM deportista_inscrito_clase WHERE clase = codClase) as Apuntados
										FROM clase, escuela, reserva, pista_tiene_horario, horario, pista, Deportista
										WHERE 	Clase.clase NOT IN (SELECT DISTINCT CLASE FROM Deportista_inscrito_clase WHERE Deportista_inscrito_clase.DNI_Deportista = ?) 
												AND clase.Reserva_Reserva = reserva.Reserva AND reserva.codigoPistayHorario = pista_tiene_horario.codigoPistayHorario 
												AND pista_tiene_horario.Horario_Horario = horario.Horario AND clase.Entrenador = Deportista.DNI
												AND pista_tiene_horario.Pista_codigoPista = pista.codigoPista AND clase.codigoEscuela = escuela.codigoEscuela
										ORDER BY Curso");
		$sql->bind_param("s", $DNI);
		$sql->execute();
		
		$resultado = $sql->get_result();
		
		if(!$resultado){
			return 'No se ha podido conectar con la BD';
		}else if($resultado->num_rows == 0){
			return 'No hay clases disponibles';
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
			return 'No se ha encontrado la clase';
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
		$sql = $this->mysqli->prepare(" SELECT 	clase.Clase as dude, escuela.nombreEscuela, clase.Entrenador, clase.Curso, clase.Particulares,
												horario.HoraInicio, horario.HoraFin, pista.nombre
										FROM clase, escuela, reserva, pista_tiene_horario, horario, pista 
										WHERE 	clase.Curso = ? AND clase.Reserva_Reserva = reserva.Reserva AND 
												reserva.codigoPistayHorario = pista_tiene_horario.codigoPistayHorario AND pista_tiene_horario.Horario_Horario = horario.Horario 
												AND pista_tiene_horario.Pista_codigoPista = pista.codigoPista AND clase.codigoEscuela = escuela.codigoEscuela
										ORDER BY Curso");
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
	
	function CURSOS(){
		$sql = $this->mysqli->prepare("SELECT DISTINCT clase.Curso FROM clase ORDER BY Curso");
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
			* Anular clase (CHECK)
			* Anular curso (CHECK)
			* Editar horas, qutiando la reserva si se da el caso (lo mismo en anular) (CHECK)
			* Ver alumnos apuntados, por si acaso no va nadie (CHECK maomeno)
			* Crear clases particulares (hora concreta hablarlo con alumno) (CHECK)
			* Crear clases grupales (CHECK)
		*/
		$sql = $this->mysqli->prepare("	SELECT 	clase.Clase, escuela.codigoEscuela, escuela.nombreEscuela, clase.Entrenador, clase.Reserva_Reserva, clase.Curso, clase.Particulares,
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
	
	function HORARIOSLIBRES(){
		$sql = $this->mysqli->prepare("SELECT pista_tiene_horario.codigoPistayHorario, pista_tiene_horario.Pista_codigoPista, pista.nombre, pista_tiene_horario.Horario_Horario, horario.HoraInicio, horario.HoraFin 
										FROM pista_tiene_horario, pista, horario 
										WHERE pista_tiene_horario.codigoPistayHorario NOT IN(SELECT reserva.codigoPistayHorario FROM reserva) 
											AND pista_tiene_horario.Pista_codigoPista = pista.codigoPista 
											AND pista_tiene_horario.Horario_Horario = horario.Horario ;");
		$sql->execute();
		
		$resultado = $sql->get_result();
		
		if(!$resultado){
			return 'No se ha podido conectar con la BD';
		}else if($resultado->num_rows == 0){
			return 'No hay horarios libres';
		}else{
			return $resultado;
		}
	}
	
	function ESCUELAS(){
		$sql = $this->mysqli->prepare("SELECT * FROM escuela ORDER BY 1");
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
	
	function CLASESDE($DNI){
		$sql = $this->mysqli->prepare("	SELECT Deportista_inscrito_clase.Clase, Clase.Entrenador, Deportista.Nombre, Deportista.Apellidos, Clase.Curso, Horario.HoraInicio, Horario.HoraFin, Pista.codigoPista, Pista.nombre 
										FROM Deportista_inscrito_clase, Clase, Horario, Deportista, Pista, Reserva, pista_tiene_horario
										WHERE Deportista_inscrito_clase.DNI_Deportista = ? AND Deportista_inscrito_clase.Clase = Clase.Clase AND Clase.Entrenador = Deportista.DNI AND
											Clase.Reserva_Reserva = Reserva.Reserva AND Reserva.codigoPistayHorario = pista_tiene_horario.codigoPistayHorario 
											AND pista_tiene_horario.Horario_Horario = Horario.Horario AND pista_tiene_horario.Pista_codigoPista = Pista.codigoPista
										ORDER BY 1");
		$sql->bind_param("s", $DNI);
		$sql->execute();
		
		$resultado = $sql->get_result();
		
		if(!$resultado){
			return "No se ha podido conectar con la BD";
		}else if($resultado->num_rows == 0){
			return "No hay clases asignadas";
		}else{
			return $resultado;
		}
	}
	
	function ALUMNOS(){
		$sql = $this->mysqli->prepare("	SELECT Deportista.DNI, Deportista.Edad, Deportista.Nombre, Deportista.Apellidos, Deportista.Sexo FROM Deportista_inscrito_clase, Deportista
										WHERE Deportista_inscrito_clase.Clase = ? AND Deportista_inscrito_clase.DNI_Deportista = Deportista.DNI ORDER BY 1");
		$sql->bind_param("i", $this->Clase);
		$sql->execute();
		
		$resultado = $sql->get_result();
		
		if(!$resultado){
			return "No se ha podido conectar con la BD";
		}else if($resultado->num_rows == 0){
			return "No hay alumnos apuntados a esta clase";
		}else{
			return $resultado;
		}
	}
	
	function APUNTAR($DNI){
		$this->_getDatosGuardados();
		$sql = $this->mysqli->prepare("SELECT COUNT(*) FROM deportista_inscrito_clase WHERE clase = ?");
		$sql->bind_param("i", $this->Clase);
		$sql->execute();
		
		$resultado = $sql->get_result();
		if(!$resultado){
			return "Fallo al apuntarse a la clase";
		}else{
			$fila = $resultado->fetch_row();
			
			if(($this->Particulares == 0 && $fila[0] >= 4) || ($this->Particulares == 1 && $fila[0] >= 3)){
				return "Demasiados apuntados a la clase, no puedes unirte";
			}
			$sql = $this->mysqli->prepare("INSERT INTO Deportista_inscrito_clase (Clase, DNI_Deportista) VALUES (?, ?)");
			$sql->bind_param("is", $this->Clase, $DNI);
			$resultado = $sql->execute();
			
			if($resultado){
				return "Apuntado a la clase con éxito";
			}else{
				return "Fallo al apuntarse a la clase";
			}
		}
	}
	
	function ABANDONAR($DNI){
		$sql = $this->mysqli->prepare("SELECT * FROM Deportista_inscrito_clase WHERE Clase = ? AND DNI_Deportista = ?");
		$sql->bind_param("is", $this->Clase, $DNI);
		$sql->execute();
		
		$resultado = $sql->get_result();
		
		if(!$resultado){
			return "No se ha podido conectar con la BD";
		}else if($resultado->num_rows == 0){
			return "No estás apuntado a esta clase";
		}else{
			$sql = $this->mysqli->prepare("DELETE FROM Deportista_inscrito_clase WHERE Clase = ? AND DNI_Deportista = ?");
			$sql->bind_param("is", $this->Clase, $DNI);
			$resultado = $sql->execute();
			
			if($resultado){
				return "Has abandonado la clase";
			}else{
				return "No se ha podido abandonar la clase";
			}
		}
	}
}
?>