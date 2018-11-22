<?php

class Partido
{
  public $Partido;
  public $codigoHorario;
  public $codigoPista;
  var $mysqli;

	function __construct($Partido,$codigoHorario,$codigoPista)
  {
  		$this ->Partido = $Partido;
  		$this ->codigoHorario = $codigoHorario;
  		$this ->codigoPista = $codigoPista;
      include_once '../Functions/ConectarBD.php'; //Actualizar
      $this->mysqli = ConectarBD();
		
	}

  public function _getPartido() {
    return $this ->Partido;
  }

  public function _getCodigoHorario() {
    return $this ->codigoHorario;
  }
  public function _getCodigoPista() {
    return $this ->codigoPista;
  }

  public function _setPartido($Partido){
    $this->Partido = $Partido;
  }

  public function _setCodigoHorario ($codigoHorario){
    $this ->codigoHorario = $codigoHorario;
  }

  public function _setCodigoPista ($codigoPista){
    $this ->codigoPista = $codigoPista;
  }  


	public function comprobarDatos() {
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
	}

  function _getDatosGuardados(){//Para recuperar de la base de datos
    if(($this->Partido == '')){
      return 'Partido vacio, introduzca un partido';
    }else{
      $sql = $this->mysqli->prepare("SELECT * FROM partido WHERE Partido = ?");
      $sql->bind_param("i", $this->Partido);
      
    $resultado = $sql->get_result();
      
      if(!$resultado){
        return 'No se ha podido conectar con la BD';
      }else if($resultado->num_rows == 0){
        return 'No existe el partido';
      }else{
        $fila = $resultado->fetch_row();
        
        $this->_setCodigoHorario($fila[1]);
        $this->_setCodigoPista($fila[2]);
      }
    }
  }


  function ADD(){//Para añadir a la BD
    $sql = $this->mysqli->prepare("INSERT INTO partido (codigoHorario, codigoPista) VALUES (?, ?)");
    $sql->bind_param("ii", $this->codigoHorario, $this->codigoPista);
    $resultado = $sql->execute();
  
    if(!$resultado){
      return 'Ha fallado el insertar el partido';
    }else{
      return 'Inserción correcta';
    }
  }
  
  function DELETE(){//Para eliminar de la BD
    $sql = $this->mysqli->prepare("SELECT * FROM partido WHERE Partido = ?");
    $sql->bind_param("i", $this->Partido);
    $sql->execute();
    
    $resultado = $sql->get_result();
    
    if(!$resultado){
      return 'No se ha podido conectar con la BD';
    }else if($resultado->num_rows == 0){
      return 'No se ha encontrado el partido';
    }else{
      $sql = $this->mysqli->prepare("DELETE FROM partido WHERE Partido = ?");
      $sql->bind_param("i", $this->Partido);
      
      $sql->execute();
      $resultado = $sql->get_result();
    
    
      /*if(!$resultado){
        return 'Fallo al eliminar la tupla';
      }
      else{*/
        return 'Partido eliminado';
      //}
    }
  }
  
  function SHOWCURRENT(){//Para mostrar de la base de datos
    $sql = $this->mysqli->prepare("SELECT * FROM partido WHERE Partido = ?");
    $sql->bind_param("i", $this->Partido);
    
    $sql->execute();
    $resultado = $sql->get_result();
    
    
    if(!$resultado){
      return 'No se ha podido conectar con la BD';
    }else if($resultado->num_rows == 0){
      return 'No existe el Partido';
    }else{
      return $resultado;
    }
  }
  
  function SHOWALL(){//Para mostrar la BD
    $sql = "SELECT * FROM partido";
    
    $resultado = $this->mysqli->query($sql);
    
    if(!$resultado){
      return 'No se ha podido conectar con la BD';
    }else{
      return $resultado;
    }
  }
}
?>