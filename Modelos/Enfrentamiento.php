<?php

class Enfrentamiento
{

  var $Enfrentamiento; //autoincrem
  var $CampeonatoCategoria;
  var $Nombre;
  var $Pareja1;
  var $Pareja2;
  var $set1;
  var $set2;
  var $set3;
  var $mysqli;
  //CampeonatoCategoria,Pareja1,Pareja2,set1,set2,set3
  
  var $codCuartos = 4;
  var $codSemis = 2;
  var $codFinal = 1;
   

	function __construct($Enfrentamiento,$Nombre,$CampeonatoCategoria,$Pareja1,$Pareja2,$set1,$set2,$set3)
  {
  		$this->Enfrentamiento = $Enfrentamiento;
		$this->Nombre = $Nombre;
  		$this->CampeonatoCategoria = $CampeonatoCategoria;
  		$this->Pareja1 = $Pareja1;
  		$this->Pareja2 = $Pareja2;
  		$this->set1= $set1;
  		$this->set2= $set2;
  		$this->set3= $set3;
      include_once '../Functions/ConectarBD.php'; //Actualizar
    $this->mysqli = ConectarBD();
	}

	public function getEnfrentamiento() {
    return $this->Enfrentamiento;
  }

  public function getNombre() {
    return $this->Nombre;
  }

  public function getCampeonatoCategoria() {
    return $this->CampeonatoCategoria;
  }

  public function getPareja1() {
    return $this->Pareja1;
  }
  public function getPareja2() {
    return $this->Pareja2;
  }
public function getSet1() {
    return $this->set1;
  }
  public function getSet2() {
    return $this->set2;
  }
  public function getSet3() {
    return $this->set3;
  }

  public function setEnfrentamiento($Enfrentamiento) {
    return $this->Enfrentamiento = $Enfrentamiento;
  }
  public function setNombre($Nombre) {
    return $this->Nombre = $Nombre;
  }
  public function setCampeonatoCategoria($CampeonatoCategoria) {
    return $this->CampeonatoCategoria = $CampeonatoCategoria;
  }
  public function setPareja1($Pareja1) {
    return $this->Pareja1 = $Pareja1;
  }
  public function setPareja2($Pareja2) {
    return $this->Pareja2 = $Pareja2;
  }
  public function setSet1($set1) {
    return $this->set1 = $set1;
  }
  public function setSet2($set2) {
    return $this->set2 = $set2;
  }
  public function setSet3($set3) {
    return $this->set3 = $set3;
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
        
        $this->setNombre($fila[1]);
        $this->setCampeonatoCategoria($fila[2]);
        $this->setPareja1($fila[3]);
        $this->setPareja2($fila[4]);
        $this->setSet1($fila[5]);
        $this->setSet2($fila[6]);
        $this->setSet3($fila[7]);
    }
  }
}
  
  
  function ADD(){//Para añadir a la BD
    $sql = $this->mysqli->prepare("INSERT INTO Enfrentamiento (CampeonatoCategoria,Pareja1,Pareja2,set1,set2,set3) VALUES (?, ?, ?, ?, ?, ?)");
    $sql->bind_param("isssss", $this->CampeonatoCategoria, $this->Pareja1,$this->Pareja2,$this->set1,$this->set2,$this->set3);
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
				$sql = $this->mysqli->prepare("UPDATE Enfrentamiento SET CampeonatoCategoria = ?, Pareja1 = ?, Pareja2 = ?, set1 = ?, set2 = ?, set3 = ?  WHERE Enfrentamiento = ?");
				$sql->bind_param("isssssi",  $this->CampeonatoCategoria, $this->Pareja1, $this->Pareja2, $this->set1, $this->set2, $this->set3, $this->Enfrentamiento);
				$resultado2 = $sql->execute();
        
				if(!$resultado2){
					return 'Ha fallado la edición de el enfrentamiento';
				}else{
					$mensajeRetorno = 'Modificado correcto</br>';
					$SegundaRonda = $resultado->fetch_row()[8];
					if($SegundaRonda == $this->codCuartos){
						//Si se introduce un resultado de cuartos, se comprueba si se han jugado todos los cuartos y se generan las semis si eso
						$mensajeRetorno = $mensajeRetorno . $this->CUARTOS();
					}else if($SegundaRonda == $this->codSemis){
						//Si se introduce un resultado de semis, se comprueba si se han jugado todos las semis y se genera la final si eso
						$mensajeRetorno = $mensajeRetorno . $this->SEMIS();
					}
					return $mensajeRetorno;
				}
			}else{
				return 'El enfrentamiento no existe';
			}
		}
	}
	
	function CUARTOS(){
		return "";
	}
	
	function SEMIS(){
		return "";
	}


  
  function SEARCH(){
    $sql = $this->mysqli->prepare("SELECT * FROM Enfrentamiento WHERE ((Enfrentamiento LIKE ?) AND (CampeonatoCategoria LIKE ?) AND (Pareja1 LIKE ?) AND (Pareja2 LIKE ?) AND (set1 LIKE ?) AND (set2 LIKE ?) AND (set3 LIKE ?))"); //No funciona
    $likeEnfrentamiento = "%" . $this->getEnfrentamiento() . "%";
    $likeCampeonatoCategoria = "%" . $this->getCampeonatoCategoria() . "%";
    $likePareja1 = "%" . $this->getPareja1() . "%";
    $likePareja2 = "%" . $this->getPareja2() . "%";
    $likeset1 = "%" . $this->getSet1() . "%";
    $likeset2 = "%" . $this->getSet2() . "%";
    $likeset3 = "%" . $this->getSet3() . "%";


    $sql->bind_param("sssssss", $likeEnfrentamiento, $likeCampeonatoCategoria, $likePareja1, $likePareja2, $likeset1, $likeset2, $likeset3  ); //Puede dar fallo facil
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