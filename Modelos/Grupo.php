<?php

class Grupo
{
  var $Grupo;
  var $nombre;
  var $CampeonatoCategoria;
  var $ParejaCategoria;
  var $mysqli;
  //nombre,CampeonatoCategoria,ParejaCategoria

	function __construct($Grupo,$nombre,$CampeonatoCategoria,$ParejaCategoria)
  {
      $this->Grupo = $Grupo;
  		$this->nombre = $nombre;
  		$this->CampeonatoCategoria = $CampeonatoCategoria;
  		$this->ParejaCategoria = $ParejaCategoria;
      include_once '../Functions/ConectarBD.php'; //Actualizar
    $this->mysqli = ConectarBD();
	}

  public function getGrupo() {
    return $this->Grupo;
  }
  public function getNombre() {
    return $this->nombre;
  }

  public function getCampeonatoCategoria() {
    return $this->CampeonatoCategoria;
  }



  public function getParejaCategoria() {
    return $this->ParejaCategoria;
  }


  public function setNombre($nombre) {
    return $this ->nombre = $nombre;
  }
  public function setCampeonatoCategoria($CampeonatoCategoria) {
     $this ->CampeonatoCategoria = $CampeonatoCategoria;
  }

  public function setParejaCategoria($ParejaCategoria) {
    return $this ->ParejaCategoria = $ParejaCategoria;
  }


function _getDatosGuardados(){//Para recuperar de la base de datos
    if(($this->Grupo == '')){
      return 'codigo de Grupo vacio, introduzca un nuevo codigo de Grupo, para recuperar el Grupo que desee';
    }else{
      $sql = $this->mysqli->prepare("SELECT * FROM Grupo WHERE Grupo = ?"); 
      $sql->bind_param("i", $this->Grupo);
      $sql->execute();
      
      $resultado = $sql->get_result();
      
      if(!$resultado){
        return 'No se ha podido conectar con la BD';
      }else if($resultado->num_rows == 0){
        return 'No existe el codigo Grupo';
      }
else{
        $fila = $resultado->fetch_row();
        
        $this->setNombre($fila[1]);
        $this->setCampeonatoCategoria($fila[2]);
        $this->setParejaCategoria($fila[3]);


    }
    }
  }
  
  
  function ADD(){//Para añadir a la BD
    $sql = $this->mysqli->prepare("INSERT INTO Grupo (nombre,CampeonatoCategoria,ParejaCategoria) VALUES (?, ?, ?)");
    $sql->bind_param("sii", $this->nombre, $this->CampeonatoCategoria,$this->ParejaCategoria);
   
    $resultado = $sql->execute();
  
    if(!$resultado){
      return 'Ha fallado el insertar un Grupo';
    }else{
      return 'Inserción correcta';
    }
  }
  
  function EDIT(){//Para editar de la BD
    if(($this->Grupo == '')){
      return 'Grupo vacio, introduzca un nuevo Grupo';
    }else{
      $sql = $this->mysqli->prepare("SELECT * FROM Grupo WHERE Grupo = ?");
      $sql->bind_param("i", $this->Grupo);
      $sql->execute();
      
      $resultado = $sql->get_result();
      
      if(!$resultado){
        return 'No se ha podido conectar con la BD';
      }else if($resultado->num_rows == 1){
        $sql = $this->mysqli->prepare("UPDATE Grupo SET nombre = ?, CampeonatoCategoria = ?, ParejaCategoria = ? WHERE Grupo = ?");
        $sql->bind_param("siii", $this->nombre, $this->CampeonatoCategoria,$this->ParejaCategoria, $this->Grupo);
        $sql->execute();
      
        $resultado = $sql->execute();
        
        if(!$resultado){
          return 'Ha fallado la actualización del grupo';
        }else{
          return 'Modificado correcto';
        }
      }else{
        return 'el grupo no existe en la base de datos';
      }
    }
  }
  
  
  function SEARCH(){
    $sql = $this->mysqli->prepare("SELECT * FROM Grupo WHERE ((Grupo LIKE ?) AND (nombre LIKE ?) AND (CampeonatoCategoria LIKE ?) AND (ParejaCategoria LIKE ?))"); //No funciona
    $likeGrupo = "%" . $this->getGrupo() . "%";
    $likenombre = "%" . $this->getNombre() . "%";
    $likeCampeonatoCategoria = "%" . $this->getCampeonatoCategoria() . "%";
    $likeParejaCategoria = "%" . $this->getParejaCategoria() . "%";
    $sql->bind_param("ssss", $likeGrupo, $likenombre, $likeCampeonatoCategoria, $likeParejaCategoria); //Puede dar fallo facil
    $sql->execute();
    
    $resultado = $sql->get_result();
    
    if(!$resultado || $resultado->num_rows == 0){
      return 'No se ha encontrado ningun dato';
    }else{
      return $resultado;
    }
  }


    
   
  
  
  function DELETE(){//Para eliminar de la BD
    $sql = $this->mysqli->prepare("SELECT * FROM Grupo WHERE Grupo = ?");
    $sql->bind_param("i", $this->Grupo);
    $sql->execute();
    
    $resultado = $sql->get_result();
    
    if(!$resultado){
      return 'No se ha podido conectar con la BD';
    }else if($resultado->num_rows == 0){
      return 'No se ha encontrado el campeonato';
    }else{
      $sql = $this->mysqli->prepare("DELETE FROM Grupo WHERE Grupo = ?");
      $sql->bind_param("i", $this->Grupo);
      $sql->execute();
      
      $resultado = $sql->execute();
    
      if(!$resultado){
        return 'Fallo al eliminar la tupla';
      }else{
        return 'grupo eliminado correctamente';
      }
    }
  }
  
  function SHOWCURRENT(){//Para mostrar de la base de datos
    $sql = $this->mysqli->prepare("SELECT * FROM Grupo WHERE Grupo = ?");
    $sql->bind_param("i", $this->Grupo);
    $sql->execute();
    
   $resultado = $sql->get_result();
    
    if(!$resultado){
      return 'No se ha podido conectar con la BD';
    }else if($resultado->num_rows == 0){
      return 'No existe el Grupo';
    }else{
      return $resultado;
    }
  }
  
  function SHOWALL(){//Para mostrar la BD
    $sql = "SELECT * FROM Grupo";
    
    $resultado = $this->mysqli->query($sql);
    
    if(!$resultado){
      return 'No se ha podido conectar con la BD';
    }else{
      return $resultado;
    }
  }
}

?>