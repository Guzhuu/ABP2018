<?php

class Pareja
{
  public $codPareja;
  public $DNI_Capitan;
  public $DNI_Companhero;
  var $mysqli;

	function __construct($codPareja,$DNI_Capitan,$DNI_Companhero)
  {
      $this ->DNI_Capitan = $DNI_Capitan;
      $this ->DNI_Companhero = $DNI_Companhero;
      $this ->codPareja= $codPareja;
      if($this ->codPareja==''){
        $this ->codPareja = $DNI_Capitan.$DNI_Companhero;
      }
    include_once '../Functions/ConectarBD.php'; //Actualizar
    $this->mysqli = ConectarBD();
	}


  public function _getCodPareja() {
    return $this ->codPareja;
  }
  public function _getDNI_Capitan() {
    return $this ->DNI_Capitan;
  }
  public function _getDNI_Companhero() {
    return $this ->DNI_Companhero;
  }

  public function _setCodPareja ($codPareja){
    $this ->codPareja = $codPareja;
  }
  public function _setDNI_Capitan($DNI_Capitan){
    $this ->DNI_Capitan = $DNI_Capitan;
  }
  public function _setDNI_Companhero ($DNI_Companhero){
    $this ->DNI_Companhero = $DNI_Companhero;
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
    if(($this->_getCodPareja() == '')){
      return 'Codigo vacio.';
    }else{
      $sql = $this->mysqli->prepare("SELECT * FROM pareja WHERE codPareja = ?");
      $sql->bind_param("s", $this->codPareja);
      $sql->execute();
      
      $resultado = $sql->get_result();
      
      if(!$resultado){
        return 'No se ha podido conectar con la BD';
      }else if($resultado->num_rows == 0){
        return 'No existe la pareja';
      }else{
        $fila = $resultado->fetch_row();
        
        $this->_setDNI_Capitan($fila[1]);
        $this->_setDNI_Companhero($fila[2]);
      }
    }
  }
  
  
  function ADD(){//Para añadir a la BD
    $sql = $this->mysqli->prepare("INSERT INTO pareja (codPareja,DNI_Capitan, DNI_Companhero) VALUES (?, ?, ?)");
    $sql->bind_param("sss",$this->codPareja, $this->DNI_Capitan, $this->DNI_Companhero);
    $resultado = $sql->execute();
    //var_dump($this->codPareja);
  
    if(!$resultado){
      return 'Ha fallado el insertar la pareja';
    }else{
      return 'Inserción correcta';
    }
  }
  
  function EDIT(){//Para editar de la BD
    if(($this->codPareja == '')){
      return 'codigo vacio';
    }else{
      $sql = $this->mysqli->prepare("SELECT * FROM pareja WHERE codPareja = ?");
      $sql->bind_param("s", $this->codPareja);
      $sql->execute();
      
      $resultado = $sql->get_result();
      
      if(!$resultado){
        return 'No se ha podido conectar con la BD';
      }else if($resultado->num_rows == 1){
        $sql = $this->mysqli->prepare("UPDATE pareja SET DNI_Capitan = ?, DNI_Companhero = ? WHERE codPareja = ?");
        $sql->bind_param("ssi", $this->DNI_Capitan, $this->DNI_Companhero, $this->codPareja);
        $resultado = $sql->execute();
        
        if(!$resultado){
          return 'Ha fallado la actualización de la pareja';
        }else{
          return 'Modificado correcto';
        }
      }else{
        return 'Pareja no existe en la base de datos';
      }
    }
  }
  
  function SEARCH(){
    $sql = $this->mysqli->prepare("SELECT * FROM pareja WHERE ((codPareja LIKE ?) AND (DNI_Capitan LIKE ?) AND (DNI_Companhero LIKE ?))"); //No funciona
    $likePareja = "%" . $this->_getCodPareja() . "%";
    $likeDNICAPITAN = "%" . $this->_getDNI_Capitan() . "%";
    $likeDNICOMPA = "%" . $this->_getDNI_Companhero() . "%";
    $sql->bind_param("iss", $likePareja, $likeDNICAPITAN, $likeDNICOMPA); //Puede dar fallo facil
    $sql->execute();
    
    $resultado = $sql->get_result();
    
    if(!$resultado || $resultado->num_rows == 0){
      return 'No se ha encontrado ningun dato';
    }else{
      return $resultado;
    }
  }
  
  function DELETE(){//Para eliminar de la BD
    $sql = $this->mysqli->prepare("SELECT * FROM pareja WHERE codPareja = ?");
    $sql->bind_param("s", $this->codPareja);
    $sql->execute();
    
    $resultado = $sql->get_result();
    
    if(!$resultado){
      return 'No se ha podido conectar con la BD';
    }else if($resultado->num_rows == 0){
      return 'No se ha encontrado el horario';
    }else{
      $sql = $this->mysqli->prepare("DELETE FROM pareja WHERE codPareja = ?");
      $sql->bind_param("s", $this->codPareja);
      $resultado = $sql->execute();
    
      if(!$resultado){
        return 'Fallo al eliminar la tupla';
      }else{
        return 'Pareja eliminada correctamente';
      }
    }
  }
  
  function SHOWCURRENT(){//Para mostrar de la base de datos
    $sql = $this->mysqli->prepare("SELECT * FROM pareja WHERE codPareja = ?");
    $sql->bind_param("s", $this->codPareja);
    
    
    $sql->execute();
    $resultado = $sql->get_result();
    
    if(!$resultado){
      return 'No se ha podido conectar con la BD';
    }else if($resultado->num_rows == 0){
      return 'No existe la pareja';
    }else{
      return $resultado;
    }
  }
  
  function SHOWALL(){//Para mostrar la BD
    $sql = "SELECT * FROM pareja";
    
    $resultado = $this->mysqli->query($sql);
    
    if(!$resultado){
      return 'No se ha podido conectar con la BD';
    }else{
      return $resultado;
    }
  }

}

?>