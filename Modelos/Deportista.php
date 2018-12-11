<?php


// file: model/ExerciseMapper.php
//require_once(__DIR__."/../core/PDOConnection.php");

//require_once(__DIR__."/../model/User.php");
//require_once(__DIR__."/../model/Ejercicio.php");



class Deportista
{
  public $DNI;
  public $Edad;
  public $Nombre;
  public $Apellidos;
  public $Sexo;
  public $Contrasenha;
  public $Cuota_socio;
  public $rolAdmin;
  public $rolEntrenador;
  var $mysqli;

	function __construct($DNI,$Edad,$Nombre,$Apellidos,$Sexo,$Contrasenha,$Cuota_socio,$rolAdmin,$rolEntrenador)
  {
  		$this->DNI = $DNI;
  		$this->Edad = $Edad;
  		$this->Nombre = $Nombre;
  		$this->Apellidos = $Apellidos;
  		$this->Sexo = $Sexo;
  		$this->Contrasenha = $Contrasenha;
  		$this->Cuota_socio = $Cuota_socio;
  		$this->rolAdmin = $rolAdmin;
  		$this->rolEntrenador = $rolEntrenador;
		include_once '../Functions/ConectarBD.php'; //Actualizar
		$this->mysqli = ConectarBD();
		
	}

  public function _getDNI() {
    return $this->DNI;
  }

  public function _getEdad() {
    return $this->Edad;
  }
  public function _getNombre() {
    return $this->Nombre;
  }

  public function _getApellidos() {
    return $this->Apellidos;
  }
  public function _getSexo() {
    return $this->Sexo;
  }
  public function _getContrasenha() {
    return $this->Contrasenha;
  }
  public function _getCuotaSocio() {
    return $this->Cuota_socio;
  }
  public function _getRolAdmin() {
    return $this->rolAdmin;
  }
  public function _getRolEntrenador() {
    return $this->rolEntrenador;
  }    


  public function _setDNI ($DNI){
    $this->DNI = $DNI;
  }

  public function _setEdad ($Edad){
    $this->Edad = $Edad;
  }
  public function _setNombre($Nombre){
	  $this->Nombre = $Nombre;
  }

  public function _setApellidos ($Apellidos){
    $this->Apellidos = $Apellidos;
  }

  public function _setSexo ($Sexo){
    $this->Sexo = $Sexo;
  }

  public function _setContrasenha ($Contrasenha){
    $this->Contrasenha = $Contrasenha;
  }

  public function _setCuotaSocio ($Cuota_socio){
    $this->Cuota_socio = $Cuota_socio;
  }

  public function _setRolAdmin ($rolAdmin){
    $this->rolAdmin = $rolAdmin;
  } 
  public function _setRolEntrenador ($rolEntrenador){
    $this->rolEntrenador = $rolEntrenador;
  }  


	/*public function comprobarDatos() {
			$errors = array();

			if (strlen(trim($this->id)) == 0 ) {
				$errors["id"] = "El ID no es válido";
			}

			if (strlen($this->duracion) == 0) {
				$errors["edad"] = "La tabla debe tener duración.";
			}

			if (sizeof($errors)>0){
				throw new ValidationException($errors, "Existen errores. No se puede registrar la tabla.");
			}
	}*/

    function _getDatosGuardados(){//Para recuperar de la base de datos
    if(($this->_getDNI() == '')){
      return 'Deportista vacio, introduzca un deportista';
    }else{
      $sql = $this->mysqli->prepare("SELECT * FROM deportista WHERE DNI = ?");
      $sql->bind_param("s", $this->DNI);
      $sql->execute();

      $resultado = $sql->get_result();
      
      if(!$resultado){
        return 'No se ha podido conectar con la BD';
      }else if($resultado->num_rows == 0){
        return 'No existe el deportista';
      }else{
        $fila = $resultado->fetch_row();
        
        $this->_setEdad($fila[1]);
        $this->_setNombre($fila[2]);
        $this->_setApellidos($fila[3]);
        $this->_setSexo($fila[4]);
        $this->_setContrasenha($fila[5]);
        $this->_setCuotaSocio($fila[6]);
        $this->_setRolAdmin($fila[7]);
        $this->_setRolEntrenador($fila[8]);
      }
    }
  }

	function LOGIN(){
		$sql = $this->mysqli->prepare("SELECT Contrasenha FROM deportista WHERE DNI = ?");
		$sql->bind_param("s", $this->DNI);
		$sql->execute();
		
		$resultado = $sql->get_result();
		
		if(!$resultado){
			return 'No se ha podido conectar con la BD';
		}else if($resultado->num_rows == 0 /* || $resultado->fetch_row()[0] == ''*/){
			return 'DNI incorrecto';
		}else{
			if($this->Contrasenha === $resultado->fetch_row()[0]){
				return 'true';
			}else{
				return 'Contraseña incorrecta';
			}
		}
	}
	
	function ADMIN(){
		$sql = $this->mysqli->prepare("SELECT rolAdmin FROM deportista WHERE DNI = ?");
		$sql->bind_param("s", $this->DNI);
		$sql->execute();
		
		$resultado = $sql->get_result();
		
		if(!$resultado){
			return 'No se ha podido conectar con la BD';
		}else if($resultado->num_rows == 0){
			return false;
		}else{
			if($resultado->fetch_assoc()["rolAdmin"]){
				return true;
			}else{
				return false;
			}
		}
	}
	
	function ENTRENADOR(){
		$sql = $this->mysqli->prepare("SELECT rolEntrenador FROM deportista WHERE DNI = ?");
		$sql->bind_param("s", $this->DNI);
		$sql->execute();
		
		$resultado = $sql->get_result();
		
		if(!$resultado){
			return 'No se ha podido conectar con la BD';
		}else if($resultado->num_rows == 0){
			return false;
		}else{
			if($resultado->fetch_assoc()["rolEntrenador"]){
				return true;
			}else{
				return false;
			}
		}
	}
	
	function SHOWAGENDA(){
		/* EL ENTRENADOR DEBE PODER: 
		* Anular clase
		* Crear clases particulares (hora concreta hablarlo con alumno)
		* Crear clases grupales
		* Anular curso
		* Ver alumnos apuntados, por si acaso no va nadie
		* Editar horas, qutiando la reserva si se da el caso (lo mismo en anular)
		
		Crear controller_clase, mejor
		
		*/
		$sql = $this->mysqli->prepare("	SELECT 	clase.Clase, escuela.codigoEscuela, escuela.nombreEscuela, clase.Entrenador, clase.Reserva_Reserva, 
												horario.Horario, horario.HoraInicio, horario.HoraFin, pista.codigoPista, pista.nombre 
										FROM clase, escuela, reserva, pista_tiene_horario, horario, pista 
										WHERE 	clase.Entrenador = ? AND clase.Reserva_Reserva = reserva.Reserva AND 
												reserva.codigoPistayHorario = pista_tiene_horario.codigoPistayHorario AND pista_tiene_horario.Horario_Horario = horario.Horario 
												AND pista_tiene_horario.Pista_codigoPista = pista.codigoPista AND clase.codigoEscuela = escuela.codigoEscuela;");
		$sql->bind_param("s", $this->DNI);
		$sql->execute();
		
		$resultado = $sql->get_result();
		
		if(!$resultado){
			return 'No se ha podido conectar con la BD';
		}else if($resultado->num_rows == 0){
			return "No tienes clases asignadas";
		}else{
			return $resultado;
		}
	}


  function ADD(){//Para añadir a la BD

    $sql = $this->mysqli->prepare("SELECT * FROM deportista WHERE DNI = ?");
    $sql->bind_param("s", $this->DNI);
    $sql->execute();
    
    $resultado = $sql->get_result();
    
    if($resultado){
      return 'Ya se ha añadido un deportista con ese DNI';
    }else{

    $sql = $this->mysqli->prepare("INSERT INTO deportista (DNI, Edad, Nombre, Apellidos, Sexo, Contrasenha,Cuota_socio
      ,rolAdmin, rolEntrenador) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $sql->bind_param("sissssiii", $this->DNI, $this->Edad, $this->Nombre,$this->Apellidos, $this->Sexo, $this->Contrasenha,  $this->Cuota_socio, $this->rolAdmin, $this->rolEntrenador);
    $resultado = $sql->execute();
  
    if(!$resultado){
      return 'Ha fallado el insertar el deportista';
    }else{
      return 'Inserción correcta';
    }
  }
  }
  
  function EDIT(){//Para editar de la BD
    if(($this->DNI == '')){
      return 'Deportista vacio, introduzca un DNI';
    }else{
      $sql = $this->mysqli->prepare("SELECT * FROM deportista WHERE DNI = ?");
      $sql->bind_param("s", $this->DNI);
      $sql->execute();
      
      $resultado = $sql->get_result();
      
      if(!$resultado){
        return 'No se ha podido conectar con la BD';
      }else if($resultado->num_rows == 1){
        $sql = $this->mysqli->prepare("UPDATE deportista SET Nombre = ?, Edad = ?, Apellidos = ?, Contrasenha = ?, Cuota_socio=?, rolAdmin = ?, rolEntrenador = ?, Sexo=? WHERE DNI = ?");
        $sql->bind_param("sissiiiss", $this->Nombre, $this->Edad, $this->Apellidos, $this->Contrasenha, $this->Cuota_socio,$this->rolAdmin,$this->rolEntrenador, $this->Sexo,$this->DNI);
        $resultado = $sql->execute();
        
        if(!$resultado){
          return 'Ha fallado la actualización de deportista';
        }else{
          return 'Modificación correcta';
        }
      }else{
        return 'Deportista no existe en la base de datos';
      }
    }
  }


  
  function SEARCH(){
    $sql = $this->mysqli->prepare("SELECT * FROM deportista WHERE ((DNI LIKE ?) AND (Edad LIKE ?) AND (Nombre LIKE ?) AND (Apellidos LIKE ?) AND (Sexo LIKE ?) AND (Cuota_socio LIKE ?) AND (rolEntrenador LIKE ?))"); //No funciona
    $likeDNI = "%" . $this->_getDNI() . "%";
    $likeEdad = "%" . $this->_getEdad() . "%";
    $likeNombre = "%" . $this->_getNombre() . "%";
    $likeApellidos = "%" . $this->_getApellidos() . "%";
    $likeSexo = "%" . $this->_getSexo() . "%";
    $likeCuota_socio = "%" . $this->_getCuotaSocio() . "%";
    $likeRolEntrenador = "%" . $this->_getRolEntrenador() . "%";
    $sql->bind_param("sssssss", $likeDNI,$likeEdad,$likeNombre,$likeApellidos,$likeSexo,$likeCuota_socio,$likeRolEntrenador); //Puede dar fallo facil
    $sql->execute();
    
    $resultado = $sql->get_result();
    
    if(!$resultado || $resultado->num_rows == 0){
      return 'No se ha encontrado ningun dato';
    }else{
      return $resultado;
    }
  }
  
  function DELETE(){//Para eliminar de la BD
    $sql = $this->mysqli->prepare("SELECT * FROM deportista WHERE DNI = ?");
    $sql->bind_param("s", $this->DNI);
    $sql->execute();
    
    $resultado = $sql->get_result();
    
    if(!$resultado){
      return 'No se ha podido conectar con la BD';
    }else if($resultado->num_rows == 0){
      return 'No se ha encontrado deportista';
    }else{
      $sql = $this->mysqli->prepare("DELETE FROM deportista WHERE DNI = ?");
      $sql->bind_param("s", $this->DNI);
      $resultado = $sql->execute();
    
      if(!$resultado){
        return 'Fallo al eliminar la tupla';
      }else{
        return 'Deportista eliminado correctamente';
      }
    }
  }
  
  function SHOWCURRENT(){//Para mostrar de la base de datos
    $sql = $this->mysqli->prepare("SELECT * FROM deportista WHERE DNI = ?");
    $sql->bind_param("s", $this->DNI);
    $sql->execute();
    
    $resultado = $sql->get_result();
    
    if(!$resultado){
      return 'No se ha podido conectar con la BD';
    }else if($resultado->num_rows == 0){
      return 'No existe deportista';
    }else{
      return $resultado;
    }
  }
  
  function SHOWALL(){//Para mostrar la BD
    $sql = "SELECT * FROM deportista";
    
    $resultado = $this->mysqli->query($sql);
    
    if(!$resultado){
      return 'No se ha podido conectar con la BD';
    }else{
      return $resultado;
    }
  }
}
?>