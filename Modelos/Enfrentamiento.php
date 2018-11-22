<?php

class Enfrentamiento
{

  var $Enfrentamiento; //autoincrem
  var $Grupo_Grupo;
  var $Pareja1;
  var $Pareja2;
  var $set1;
  var $set2;
  var $set3;
  var $mysqli;
  //Grupo_Grupo,Pareja1,Pareja2,set1,set2,set3
   

	function __construct($Enfrentamiento,$Grupo_Grupo,$Pareja1,$Pareja2,$set1,$set2,$set3)
  {
  		$this ->Enfrentamiento = $Enfrentamiento;
  		$this ->Grupo_Grupo = $Grupo_Grupo;
  		$this ->Pareja1 = $Pareja1;
  		$this ->Pareja2 = $Pareja2;
  		$this ->set1= $set1;
  		$this ->set2= $set2;
  		$this ->set3= $set3;
      include_once '../Functions/ConectarBD.php'; //Actualizar
    $this->mysqli = ConectarBD();
	}

	public function getEnfrentamiento() {
    return $this ->Enfrentamiento;
  }

  public function getGrupo_Grupo() {
    return $this ->Grupo_Grupo;
  }

  public function getPareja1() {
    return $this ->Pareja1;
  }
  public function getPareja2() {
    return $this ->Pareja2;
  }
public function getSet1() {
    return $this ->set1;
  }
  public function getSet2() {
    return $this ->set2;
  }
  public function getSet3() {
    return $this ->set3;
  }

  public function setEnfrentamiento($Enfrentamiento) {
    return $this ->Enfrentamiento = $Enfrentamiento;
  }
  public function setGrupo_Grupo($Grupo_Grupo) {
    return $this ->Grupo_Grupo = $Grupo_Grupo;
  }
  public function setPareja1($Pareja1) {
    return $this ->Pareja1 = $Pareja1;
  }
  public function setPareja2($Pareja2) {
    return $this ->Pareja2 = $Pareja2;
  }
  public function setSet1($set1) {
    return $this ->set1 = $set1;
  }
  public function setSet2($set2) {
    return $this ->set2 = $set2;
  }
  public function setSet3($set3) {
    return $this ->set3 = $set3;
  }
 
  function _getDatosGuardados(){//Para recuperar de la base de datos
    if(($this->Enfrentamiento == '')){
      return 'codigo de Enfrentamiento vacio, introduzca un nuevo codigo de Enfrentamiento, para recuperar el Enfrentamiento que desee';
    }else{
      $sql = $this->mysqli->prepare("SELECT * FROM Enfrentamiento WHERE Enfrentamiento = ?"); 
      $sql->bind_param("i", $this->Enfrentamiento);
      $sql->execute();
      
      $resultado = $sql->get_result();
      
      if(!$resultado){
        return 'No se ha podido conectar con la BD';
      }else if($resultado->num_rows == 0){
        return 'No existe el codigo Enfrentamiento';
      }
      else{
        $fila = $resultado->fetch_row();
        
        $this->setGrupo_Grupo($fila[1]);
        $this->setPareja1($fila[2]);
        $this->setPareja2($fila[3]);
        $this->setSet1($fila[4]);
        $this->setSet2($fila[5]);
        $this->setSet3($fila[6]);
    }
  }
}
  
  
  function ADD(){//Para añadir a la BD
    $sql = $this->mysqli->prepare("INSERT INTO Enfrentamiento (Grupo_Grupo,Pareja1,Pareja2,set1,set2,set3) VALUES (?, ?, ?, ?, ?, ?)");
    $sql->bind_param("isssss", $this->Grupo_Grupo, $this->Pareja1,$this->Pareja2,$this->set1,$this->set2,$this->set3);
    $sql->execute();
    
    $resultado = $sql->get_result();
        
        if(!$resultado){
          return 'Ha fallado la actualización de el Enfrentamiento';
        }else{
          return 'Modificado correcto';
        }
      
    }  
  

function EDIT(){//Para editar de la BD
    if(($this->Enfrentamiento == '')){
      return 'Enfrentamiento vacio, introduzca un Enfrentamiento';
    }else{
      $sql = $this->mysqli->prepare("SELECT * FROM Enfrentamiento WHERE Enfrentamiento = ?");
      $sql->bind_param("i", $this->Enfrentamiento);
      $sql->execute();
      
      $resultado = $sql->get_result();
      
      if(!$resultado){
        return 'No se ha podido conectar con la BD';
      }else if($resultado->num_rows == 1){
        $sql = $this->mysqli->prepare("UPDATE Enfrentamiento SET Grupo_Grupo = ?, Pareja1 = ?, Pareja2 = ?, set1 = ?, set2 = ?, set3 = ?  WHERE Enfrentamiento = ?");
        $sql->bind_param("isssssi",  $this->Grupo_Grupo, $this->Pareja1, $this->Pareja2, $this->set1, $this->set2, $this->set3, $this->Enfrentamiento);
        $resultado = $sql->execute();
        
        if(!$resultado){
          return 'Ha fallado la actualización de el Enfrentamiento';
        }else{
          return 'Modificado correcto';
        }
      }else{
        return 'el Enfrentamiento no existe en la base de datos';
      }
    }
  }


  
  function SEARCH(){
    $sql = $this->mysqli->prepare("SELECT * FROM Enfrentamiento WHERE ((Enfrentamiento LIKE ?) AND (Grupo_Grupo LIKE ?) AND (Pareja1 LIKE ?) AND (Pareja2 LIKE ?) AND (set1 LIKE ?) AND (set2 LIKE ?) AND (set3 LIKE ?))"); //No funciona
    $likeEnfrentamiento = "%" . $this->getEnfrentamiento() . "%";
    $likeGrupo_Grupo = "%" . $this->getGrupo_Grupo() . "%";
    $likePareja1 = "%" . $this->getPareja1() . "%";
    $likePareja2 = "%" . $this->getPareja2() . "%";
    $likeset1 = "%" . $this->getSet1() . "%";
    $likeset2 = "%" . $this->getSet2() . "%";
    $likeset3 = "%" . $this->getSet3() . "%";


    $sql->bind_param("sssssss", $likeEnfrentamiento, $likeGrupo_Grupo, $likePareja1, $likePareja2, $likeset1, $likeset2, $likeset3  ); //Puede dar fallo facil
    $sql->execute();
    
    $resultado = $sql->get_result();
    
    if(!$resultado || $resultado->num_rows == 0){
      return 'No se ha encontrado ningun dato';
    }else{
      return $resultado;
    }
  }
  
  
  function DELETE(){//Para eliminar de la BD
    $sql = $this->mysqli->prepare("SELECT * FROM Enfrentamiento WHERE Enfrentamiento = ?");
    $sql->bind_param("i", $this->Enfrentamiento);
    $sql->execute();
    
    $resultado = $sql->get_result();
    
    if(!$resultado){
      return 'No se ha podido conectar con la BD';
    }else if($resultado->num_rows == 0){
      return 'No se ha encontrado el Enfrentamiento';
    }else{
      $sql = $this->mysqli->prepare("DELETE FROM Enfrentamiento WHERE Enfrentamiento = ?");
      $sql->bind_param("i", $this->Enfrentamiento);
      $sql->execute();
      
      $resultado = $sql->execute();
    
      if(!$resultado){
        return 'Fallo al eliminar la tupla';
      }else{
        return 'Enfrentamiento eliminado correctamente';
      }
    }
  }
  
  function SHOWCURRENT(){//Para mostrar de la base de datos
    $sql = $this->mysqli->prepare("SELECT * FROM Enfrentamiento WHERE Enfrentamiento = ?");
    $sql->bind_param("i", $this->Enfrentamiento);
    $sql->execute();
    
    $resultado = $sql->get_result();
    
    if(!$resultado){
      return 'No se ha podido conectar con la BD';
    }else if($resultado->num_rows == 0){
      return 'No existe el Enfrentamiento';
    }else{
      return $resultado;
    }
  }
  
  function SHOWALL(){//Para mostrar la BD
    $sql = "SELECT * FROM Enfrentamiento";
    
    $resultado = $this->mysqli->query($sql);
    
    if(!$resultado){
      return 'No se ha podido conectar con la BD';
    }else{
      return $resultado;
    }
  }

}

?>