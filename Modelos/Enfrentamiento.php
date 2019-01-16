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
	var $codTercerCuartoPuesto = 3;
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
		if($this->Nombre === null){
			$sql = $this->mysqli->prepare("INSERT INTO Enfrentamiento (CampeonatoCategoria,Pareja1,Pareja2,set1,set2,set3) VALUES (?, ?, ?, ?, ?, ?)");
			$sql->bind_param("isssss", $this->CampeonatoCategoria, $this->Pareja1,$this->Pareja2,$this->set1,$this->set2,$this->set3);
			$sql->execute();
			$resultado = $sql->get_result();
		
			
			if(!$resultado){
			  return 'Ha fallado la actualización de el Enfrentamiento';
			}else{
			  return 'Modificado correcto';
			}
		}else{
			$sql = $this->mysqli->prepare("INSERT INTO Enfrentamiento (CampeonatoCategoria,nombre,Pareja1,Pareja2,set1,set2,set3) VALUES (?, ?, ?, ?, ?, ?)");
			$sql->bind_param("issssss", $this->CampeonatoCategoria, $this->Nombre, $this->Pareja1,$this->Pareja2,$this->set1,$this->set2,$this->set3);
			$sql->execute();
			$resultado = $sql->get_result();
		
			
			if(!$resultado){
			  return 'Ha fallado la actualización de el Enfrentamiento';
			}else{
			  return 'Modificado correcto';
			}
		}
	}  
	
	function setsCorrectos(){
		if($set1 = $this->setCorrecto($this->set1)){
			if($set2 = $this->setCorrecto($this->set2)){
				if($set3 = $this->setCorrecto($this->set3)){
					return "true";
				}else{
					return "Set 3: " . $this->set3 . "; (X-X) y X <= 6";
				}
			}else{
				return "Set 2: " . $this->set2 . "; (X-X) y X <= 6";
			}
		}else{
			return "Set 1: " . $this->set1 . "; (X-X) y X <= 6";
		}
	}
	
	function setCorrecto($set){
		$valores = array('0', '1', '2', '3', '4', '5');
		if(is_string($set) && strlen($set) == 3 && 
			((substr($set, 0, 1) == '6' && substr($set, 1, 1) == '-' && in_array(substr($set, 2, 1), $valores)) || 
			 (substr($set, 2, 1) == '6' && substr($set, 1, 1) == '-' && in_array(substr($set, 0, 1), $valores)))){
				 return true;
		}else{
			return false;
		}
	}
  

	function EDIT(){//Para editar de la BD
		if(($this->Enfrentamiento == '')){
			return 'Enfrentamiento vacio, introduzca un Enfrentamiento';
		}else if($this->setsCorrectos() != "true"){
			return 'Hay uno o varios sets mal puestos: ' . $this->setsCorrectos();
		}else{		
			$sql = $this->mysqli->prepare("SELECT * FROM Enfrentamiento WHERE Enfrentamiento = ?");
			$sql->bind_param("i", $this->Enfrentamiento);
			$sql->execute();
      
			$resultado = $sql->get_result();
      
			if(!$resultado){
				return 'No se ha podido conectar con la BD';
			}else if($resultado->num_rows == 1){
				$resultado2 = false;
				
				if($this->Nombre === null){
					$sql = $this->mysqli->prepare("UPDATE Enfrentamiento SET CampeonatoCategoria = ?, Pareja1 = ?, Pareja2 = ?, set1 = ?, set2 = ?, set3 = ?  WHERE Enfrentamiento = ?");
					$sql->bind_param("isssssi",  $this->CampeonatoCategoria, $this->Pareja1, $this->Pareja2, $this->set1, $this->set2, $this->set3, $this->Enfrentamiento);
					$resultado2 = $sql->execute();
				}else{
					$sql = $this->mysqli->prepare("UPDATE Enfrentamiento SET CampeonatoCategoria = ?, nombre = ?, Pareja1 = ?, Pareja2 = ?, set1 = ?, set2 = ?, set3 = ?  WHERE Enfrentamiento = ?");
					$sql->bind_param("issssssi",  $this->CampeonatoCategoria, $this->Nombre, $this->Pareja1, $this->Pareja2, $this->set1, $this->set2, $this->set3, $this->Enfrentamiento);
					$resultado2 = $sql->execute();
				}
        
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
		$sql = $this->mysqli->prepare("	SELECT Enfrentamiento.Pareja1, Enfrentamiento.Pareja2, Enfrentamiento.SegundaRonda, Enfrentamiento.set1, Enfrentamiento.set2, Enfrentamiento.set3
										FROM Enfrentamiento 
										WHERE CampeonatoCategoria = ? AND SegundaRonda = ? AND (set1 <> '0-0' OR set2 <> '0-0' OR set3 <> '0-0')");
		$sql->bind_param("ii", $this->CampeonatoCategoria, $this->codCuartos);
		$sql->execute();
  
		$resultado = $sql->get_result();
		
		$mensajeRetorno = "";
		
		if(!$resultado){
			return '';
		}else if($resultado->num_rows != 4){
			return '';
		}else{
			$sqlParejas = array();
			$sqlCount = 0;
			while($fila = $resultado->fetch_row()){
				if($this->acabado($fila)){
					$sqlParejas[$sqlCount++] = $this->ganador($fila);
				}else{
					return 'El resultado entre ' . $fila[0] . ' y ' . $fila[1] . ' está mal (' . $fila[3] . ' ' . $fila[4] . ' ' . $fila[5] . ')';
				}
			}
			//Si llega hasta aquí, todo resultado debería estar bien, así que se ponen las semis en la BD (si existen se borran las semis y la final)
			$sql = $this->mysqli->prepare("	DELETE FROM Enfrentamiento WHERE CampeonatoCategoria = ? AND (SegundaRonda = ? OR SegundaRonda = ?)");
			$sql->bind_param("iii", $this->CampeonatoCategoria, $this->codSemis, $this->codFinal);
			$sql->execute();
			
			shuffle($sqlParejas);shuffle($sqlParejas);shuffle($sqlParejas);shuffle($sqlParejas);shuffle($sqlParejas);shuffle($sqlParejas);shuffle($sqlParejas);shuffle($sqlParejas);shuffle($sqlParejas);//Random
			
			for($i = 0; $i < 2; $i++){
				$sql = $this->mysqli->prepare("	INSERT INTO Enfrentamiento (CampeonatoCategoria, Pareja1, Pareja2, set1, set2, set3, SegundaRonda) VALUES (?, ?, ?, '0-0', '0-0', '0-0', ?)");
				$sql->bind_param("issi", $this->CampeonatoCategoria, $sqlParejas[$i], $sqlParejas[sizeof($sqlParejas) - $i - 1], $this->codSemis);
				if($sql->execute()){
					$mensajeRetorno = $mensajeRetorno . "Se ha generado la semifinal entre " . $sqlParejas[$i] . ' y ' . $sqlParejas[sizeof($sqlParejas) - $i - 1] . "</br>";
				}else{
					$mensajeRetorno = "Error al generar el enfrentamiento entre " . $sqlParejas[$i] . ' y ' . $sqlParejas[sizeof($sqlParejas) - $i - 1] . "</br>";
					break;
				}
			}
		}
		return $mensajeRetorno;
	}
	
	function SEMIS(){
		$sql = $this->mysqli->prepare("	SELECT Enfrentamiento.Pareja1, Enfrentamiento.Pareja2, Enfrentamiento.SegundaRonda, Enfrentamiento.set1, Enfrentamiento.set2, Enfrentamiento.set3
										FROM Enfrentamiento 
										WHERE CampeonatoCategoria = ? AND SegundaRonda = ? AND (set1 <> '0-0' OR set2 <> '0-0' OR set3 <> '0-0')");
		$sql->bind_param("ii", $this->CampeonatoCategoria, $this->codSemis);
		$sql->execute();
  
		$resultado = $sql->get_result();
		
		$mensajeRetorno = "";
		
		if(!$resultado){
			return '';
		}else if($resultado->num_rows != 2){
			return '';
		}else{
			$sqlGanadores = array();
			$sqlPerdedores = array();
			$sqlGanadoresCount = 0;
			$sqlPerdedoresCount = 0;
			while($fila = $resultado->fetch_row()){
				if($this->acabado($fila)){
					$Ganador = $this->ganador($fila);
					$Perdedor = "";
					if($Ganador === $fila[0]){
						$Perdedor = $fila[1];
					}else{
						$Perdedor = $fila[0];
					}
					$sqlGanadores[$sqlGanadoresCount++] = $Ganador;
					$sqlPerdedores[$sqlPerdedoresCount++] = $Perdedor;
				}else{
					return 'El resultado entre ' . $fila[0] . ' y ' . $fila[1] . ' está mal (' . $fila[3] . ' ' . $fila[4] . ' ' . $fila[5] . ')';
				}
			}
			
			$sql = $this->mysqli->prepare("	INSERT IGNORE INTO Enfrentamiento (CampeonatoCategoria, Pareja1, Pareja2, set1, set2, set3, SegundaRonda) VALUES (?, ?, ?, '0-0', '0-0', '0-0', ?)");
			$sql->bind_param("issi", $this->CampeonatoCategoria, $sqlGanadores[0], $sqlGanadores[sizeof($sqlGanadores) - 0 - 1], $this->codFinal);
			if($sql->execute()){
				$mensajeRetorno = $mensajeRetorno . "Se ha generado la final entre " . $sqlGanadores[0] . ' y ' . $sqlGanadores[sizeof($sqlGanadores) - 0 - 1] . "</br>";
			}else{
				$mensajeRetorno = "Error al generar el enfrentamiento entre " . $sqlGanadores[0] . ' y ' . $sqlGanadores[sizeof($sqlGanadores) - 0 - 1] . "</br>";
				return $mensajeRetorno;
			}
			
			$sql = $this->mysqli->prepare("	INSERT IGNORE INTO Enfrentamiento (CampeonatoCategoria, Pareja1, Pareja2, set1, set2, set3, SegundaRonda) VALUES (?, ?, ?, '0-0', '0-0', '0-0', ?)");
			$sql->bind_param("issi", $this->CampeonatoCategoria, $sqlPerdedores[0], $sqlPerdedores[sizeof($sqlPerdedores) - 0 - 1], $this->codTercerCuartoPuesto);
			if($sql->execute()){
				$mensajeRetorno = $mensajeRetorno . "Se ha generado el tercer-cuarto puesto entre " . $sqlPerdedores[0] . ' y ' . $sqlPerdedores[sizeof($sqlPerdedores) - 0 - 1] . "</br>";
			}else{
				$mensajeRetorno = "Error al generar el enfrentamiento entre " . $sqlPerdedores[0] . ' y ' . $sqlPerdedores[sizeof($sqlPerdedores) - 0 - 1] . "</br>";
			}
		}
		return $mensajeRetorno;
	}
	
	function acabado($fila){
		$set1 = explode('-', $fila[3]);
		$set2 = explode('-', $fila[4]);
		$set3 = explode('-', $fila[5]);
		if(sizeof($set1) != 2 OR sizeof($set2) != 2 OR sizeof($set3) != 2){
			return false;
		}
		
		if(($set1[0] === '6' || $set1[1] === '6') && ($set2[0] === '6' || $set2[1] === '6') && ($set3[0] === '6' || $set3[1] === '6')){
			return true;
		}else{
			return false;
		}
	}
	
	function ganador($fila){
		$set1 = $fila[3];
		$set2 = $fila[4];
		$set3 = $fila[5];
		
		if($this->ganadorDe($set1) + $this->ganadorDe($set2) + $this->ganadorDe($set3) < 0){
			return $fila[0];
		}else{
			return $fila[1];
		}
	}
	
	function ganadorDe($set){
		if(substr($set, 0, 1) === '6'){
			return -1;
		}else if(substr($set, 2, 1) === '6'){
			return 1;
		}else{
			return 0;
		}
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
  
	function DEPORTISTASENFRENTAMIENTO(){
		$sql = $this->mysqli->prepare("SELECT Deportista.DNI, Deportista.Nombre, Deportista.Apellidos FROM Deportista");
		$sql->execute();
    
		$resultado = $sql->get_result();
    
		if(!$resultado){
			return 'No se ha podido conectar con la BD';
		}else{
			$respuesta = array();
			
			while($fila = $resultado->fetch_row()){
				$respuesta[$fila[0]] = $fila[1] . " " . $fila[2];
			}
			
			return $respuesta;
		}
	}

}

?>
