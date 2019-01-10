<?php

class Categoria
{
  var $Categoria;
  var $Nivel;
  var $Sexo;
  var $mysqli;

	function __construct($Categoria,$Nivel,$Sexo)
  {
      $this ->Categoria = $Categoria;
  		$this ->Nivel = $Nivel;
  		$this ->Sexo = $Sexo;
  			include_once '../Functions/ConectarBD.php'; //Actualizar
    $this->mysqli = ConectarBD();
	}

  public function getCategoria() {
    return $this ->Categoria;
  }
  public function getNivel() {
    return $this ->Nivel;
  }

  public function getSexo() {
    return $this ->Sexo;
  }
  
  public function setCategoria ($Categoria){
    $this ->Categoria = $Categoria;
  }
  public function setNivel ($Nivel){
    $this ->Nivel = $Nivel;
  }

  public function setSexo ($Sexo){
    $this ->Sexo = $Sexo;
  }
  

	function _getDatosGuardados(){//Para recuperar de la base de datos
    if(($this->Categoria == '')){
      return 'codigo de Categoria vacio, introduzca un nuevo codigo de Categoria, para recuperar la Categoria que desee';
    }else{
      $sql = $this->mysqli->prepare("SELECT * FROM Categoria WHERE Categoria = ?"); 
      $sql->bind_param("i", $this->Categoria);
      $sql->execute();
      
      $resultado = $sql->get_result();
      
      if(!$resultado){
        return 'No se ha podido conectar con la BD';
      }else if($resultado->num_rows == 0){
        return 'No existe el codigo Categoria';
      }

      else{
        $fila = $resultado->fetch_row();
        
        $this->setNivel($fila[1]);
        $this->setSexo($fila[2]);
      
    }
  }
  
  }
  function ADD(){//Para añadir a la BD
    $sql = $this->mysqli->prepare("INSERT INTO Categoria (Nivel,Sexo) VALUES (?, ?)");
    $sql->bind_param("is", $this->Nivel, $this->Sexo);
    $resultado = $sql->execute();
  
    if(!$resultado){
      return 'Ha fallado el insertar una Categoria';
    }else{
      return 'Inserción correcta';
    }
  }
  
    

function EDIT(){//Para editar de la BD
    if(($this->Categoria == '')){
      return 'Categoria vacia, introduzca una categoria';
    }else{
      $sql = $this->mysqli->prepare("SELECT * FROM Categoria WHERE Categoria = ?");
      $sql->bind_param("i", $this->Categoria);
      $sql->execute();
      
      $resultado = $sql->get_result();
      
      if(!$resultado){
        return 'No se ha podido conectar con la BD';
      }else if($resultado->num_rows == 1){
        $sql = $this->mysqli->prepare("UPDATE Categoria SET Nivel = ?, Sexo = ?  WHERE Categoria = ?");
        $sql->bind_param("ssi", $this->Nivel, $this->Sexo, $this->Categoria);
        $resultado = $sql->execute();
        
        if(!$resultado){
          return 'Ha fallado la actualización de la categoria';
        }else{
          return 'Modificado correcto';
        }
      }else{
        return 'La categoria no existe en la base de datos';
      }
    }
  }



  function SEARCH(){
    $sql = $this->mysqli->prepare("SELECT * FROM Categoria WHERE ((Categoria LIKE ?) AND (Nivel LIKE ?) AND (Sexo = ?))");
    $likeCat = "%" . $this->getCategoria() . "%";
    $likeNiv = "%" . $this->getNivel() . "%";
    $likeSex = $this->getSexo();
    $sql->bind_param("sss", $likeCat, $likeNiv, $likeSex); 
    $sql->execute();
    
    $resultado = $sql->get_result();
    
    if(!$resultado || $resultado->num_rows == 0){
      return 'No se ha encontrado ningun dato';
    }else{
      return $resultado;
    }
  }
  
  
  function DELETE(){//Para eliminar de la BD
    $sql = $this->mysqli->prepare("SELECT * FROM Categoria WHERE Categoria = ?");
    $sql->bind_param("i", $this->Categoria);
    $sql->execute();
    
    $resultado = $sql->get_result();
    
    if(!$resultado){
      return 'No se ha podido conectar con la BD';
    }else if($resultado->num_rows == 0){
      return 'No se ha encontrado el Categoria';
    }else{
      $sql = $this->mysqli->prepare("DELETE FROM Categoria WHERE Categoria = ?");
      $sql->bind_param("i", $this->Categoria);
      $sql->execute();
      
      $resultado = $sql->execute();
    
      if(!$resultado){
          return 'Ha fallado la actualización de la categoria';
        }else{
          return 'Categoría eliminada';
        }
      }
    }
  





  
  function SHOWCURRENT(){//Para mostrar de la base de datos
    $sql = $this->mysqli->prepare("SELECT * FROM Categoria WHERE Categoria = ?");
    $sql->bind_param("i", $this->Categoria);
    $sql->execute();
    
    $resultado = $sql->get_result();
    
    if(!$resultado){
      return 'No se ha podido conectar con la BD';
    }else if($resultado->num_rows == 0){
      return 'No existe el Categoria';
    }else{
      return $resultado;
    }
  }
  
  function SHOWALL(){//Para mostrar la BD
    $sql = "SELECT * FROM Categoria";
    
    $resultado = $this->mysqli->query($sql);
    
    if(!$resultado){
      return 'No se ha podido conectar con la BD';
    }else{
      return $resultado;
    }
  }

}

?>