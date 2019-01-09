<?php

class Campeonato
{
  var $Campeonato; //pk autoincremental
  var $FechaInicio;
  var $FechaFinal;
  var $Nombre;
  var $mysqli;
    

	function __construct($Campeonato,$FechaInicio,$FechaFinal,$Nombre)
  {   
      $this ->Campeonato=$Campeonato;
  		$this ->FechaInicio = $FechaInicio;
  		$this ->FechaFinal = $FechaFinal;
  		$this ->Nombre = $Nombre;
  		include_once '../Functions/ConectarBD.php'; //Actualizar
    $this->mysqli = ConectarBD();
	}


  public function getCampeonato() {
    return $this ->Campeonato;
  }

  public function getFechaInicio() {
    return $this ->FechaInicio;
  }

  public function getFechaFinal() {
    return $this ->FechaFinal;
  }
  public function getNombre() {
    return $this ->Nombre;
  }

   public function setCampeonato($Campeonato) {
    return $this ->Campeonato = $Campeonato;
  }

  public function setFechaInicio($FechaInicio) {
    return $this ->FechaInicio = $FechaInicio;
  }

  public function setFechaFinal($FechaFinal) {
    return $this ->FechaFinal = $FechaFinal;
  }
  public function setNombre($Nombre) {
    return $this ->Nombre = $Nombre;
  }

function _getDatosGuardados(){//Para recuperar de la base de datos
    if(($this->Campeonato == '')){
      return 'codigo de campeonato vacio, introduzca un nuevo codigo campeonato, para recuperar el campeonato que desee';
    }else{
      $sql = $this->mysqli->prepare("SELECT * FROM Campeonato WHERE Campeonato = ?"); 
      $sql->bind_param("i", $this->Campeonato);
      $sql->execute();
      
      $resultado = $sql->get_result();
      
      if(!$resultado){
        return 'No se ha podido conectar con la BD';
      }else if($resultado->num_rows == 0){
        return 'No existe el codigo campeonato';
}
        else{
        $fila = $resultado->fetch_row();
        
        $this->setFechaInicio($fila[1]);
        $this->setFechaFinal($fila[2]);
        $this->setNombre($fila[3]);
      }
    }
  }
  
  
  function ADD(){//Para añadir a la BD
    $sql = $this->mysqli->prepare("INSERT INTO Campeonato (FechaInicio,FechaFinal,Nombre) VALUES (?, ?, ?)");
    $sql->bind_param("sss", $this->FechaFinal, $this->FechaFinal,$this->Nombre);
   
    $resultado = $sql->execute();
  
    if(!$resultado){
      return 'Ha fallado el insertar un campeonato';
    }else{
      return 'Inserción correcta';
    }
  }
  
  
  function EDIT(){//Para editar de la BD
    if(($this->Campeonato == '')){
      return 'Campeonato vacio, introduzca un nuevo campeonato';
    }else{
      $sql = $this->mysqli->prepare("SELECT * FROM Campeonato WHERE Campeonato = ?");
      $sql->bind_param("i", $this->Campeonato);
      $sql->execute();
      
      $resultado = $sql->get_result();
      
      if(!$resultado){
        return 'No se ha podido conectar con la BD';
      }else if($resultado->num_rows == 1){
        $sql = $this->mysqli->prepare("UPDATE Campeonato SET FechaInicio = ?, FechaFinal = ?, Nombre = ?  WHERE Campeonato = ?");
        $sql->bind_param("sssi",  $this->FechaInicio, $this->FechaFinal, $this->Nombre, $this->Campeonato );
        $sql->execute();
      
        $resultado = $sql->execute();
        
        if(!$resultado){
          return 'Ha fallado la actualización del campeonato';
        }else{
          return 'Modificado correcto';
        }
      }else{
        return 'el campeonato no existe en la base de datos';
      }
    }
  }
  
   function SEARCH(){
    $sql = $this->mysqli->prepare("SELECT * FROM Campeonato WHERE ((Campeonato LIKE ?) AND (FechaInicio LIKE ?) AND (FechaFinal LIKE ?) AND (Nombre LIKE ?))"); //No funciona
    $likeCampeonato = "%" . $this->getCampeonato() . "%";
    $likeFechaInicio = "%" . $this->getFechaInicio() . "%";
    $likeFechaFinal = "%" . $this->getFechaFinal() . "%";
    $likeNombre = "%" . $this->getNombre() . "%";
    $sql->bind_param("ssss", $likeCampeonato, $likeFechaInicio, $likeFechaFinal, $likeNombre); //Puede dar fallo facil
    $sql->execute();
    
    $resultado = $sql->get_result();
    
    if(!$resultado || $resultado->num_rows == 0){
      return 'No se ha encontrado ningun dato';
    }else{
      return $resultado;
    }
  }
  
  
	function DELETE(){//Para eliminar de la BD
		$sql = $this->mysqli->prepare("SELECT * FROM Campeonato WHERE Campeonato = ?");
		$sql->bind_param("i", $this->Campeonato);
		$sql->execute();
    
		$resultado = $sql->get_result();
    
		if(!$resultado){
			return 'No se ha podido conectar con la BD';
		}else if($resultado->num_rows == 0){
			return 'No se ha encontrado el campeonato';
		}else{
			$sql = $this->mysqli->prepare("DELETE FROM Campeonato WHERE Campeonato = ?");
			$sql->bind_param("i", $this->Campeonato);
			$resultado = $sql->execute();
    
			if(!$resultado){
				return 'Fallo al eliminar el campeonato';
			}else{
				return 'Campeonato eliminado';
			}
		}
	}
  
  function SHOWCURRENT(){//Para mostrar de la base de datos
    $sql = $this->mysqli->prepare("SELECT * FROM Campeonato WHERE Campeonato = ?");
    $sql->bind_param("i", $this->Campeonato);
    $sql->execute();
    
    $resultado = $sql->get_result();
    
    if(!$resultado){
      return 'No se ha podido conectar con la BD';
    }else if($resultado->num_rows == 0){
      return 'No existe el campeonato';
    }else{
      return $resultado;
    }
  }
  
  function SHOWALL(){//Para mostrar la BD
    $sql = "SELECT * FROM Campeonato";
    
   $resultado = $this->mysqli->query($sql);
    
    if(!$resultado){
      return 'No se ha podido conectar con la BD';
    }else{
      return $resultado;
    }
  }

}



?>