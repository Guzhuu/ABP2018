<?php

class Campeonato
{
  var $Campeonato; //pk autoincremental
  var $FechaInicio;
  var $FechaFinal;
  var $Nombre;
  var $mysqli;
    
	var $codCuartos = 4;
	var $codSemis = 2;
	var $codFinal = 1;
	var $stringCodPareja = "codPareja";

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
		$sql = "	SELECT Campeonato.Campeonato, Campeonato.FechaInicio, Campeonato.FechaFinal, Campeonato.Nombre, null, null, null FROM Campeonato WHERE Campeonato.Campeonato NOT IN 
						(SELECT Campeonato_consta_de_categorias.Campeonato_Campeonato FROM Campeonato_consta_de_categorias) AND Campeonato.FechaFinal >= CURDATE()
					UNION
					SELECT Campeonato.Campeonato, Campeonato.FechaInicio, Campeonato.FechaFinal, Campeonato.Nombre, Categoria.Categoria, Categoria.Nivel, Categoria.Sexo
					FROM Campeonato, Campeonato_consta_de_categorias, Categoria WHERE Campeonato.Campeonato = Campeonato_consta_de_categorias.Campeonato_Campeonato 
						AND Campeonato_consta_de_categorias.Categoria_Categoria = Categoria.Categoria AND Campeonato.FechaFinal >= CURDATE()
					ORDER BY 1";
    
		$resultado = $this->mysqli->query($sql);
    
		if(!$resultado){
			return 'No se ha podido conectar con la BD';
		}else{
			return $resultado;
		}
	}
  
	function ADDCATEGORIA($Categoria){
		$sql = $this->mysqli->prepare("SELECT Comenzado FROM Campeonato WHERE Campeonato.Campeonato = ?");
		$sql->bind_param("i", $this->Campeonato);
		$sql->execute();
    
		$resultado = $sql->get_result();
		
		if(!$resultado){
			return 'No se ha podido conectar con la BD';
		}else if($resultado->num_rows != 1){
			return 'No se ha encontrado el campeonato';
		}else{
			$fila = $resultado->fetch_row();
			if($fila[0] == 1){
				return 'El campeonato ya ha comenzado, no puedes añadir una categoría';
			}
			
			$sql = $this->mysqli->prepare("SELECT * FROM campeonato_consta_de_categorias WHERE Campeonato_Campeonato = ? AND Categoria_Categoria = ?");
			$sql->bind_param("ii", $this->Campeonato, $Categoria);
			$sql->execute();
		
			$resultado = $sql->get_result();
		
			if(!$resultado){
				return 'No se ha podido conectar con la BD';
			}else if($resultado->num_rows != 0){
				return 'El campeonato ya tiene asociada la categoria';
			}else{
				$sql = $this->mysqli->prepare("INSERT INTO campeonato_consta_de_categorias (Campeonato_Campeonato, Categoria_Categoria) VALUES (?, ?)");
				$sql->bind_param("ii", $this->Campeonato, $Categoria);
				$resultado = $sql->execute();
				
				if($resultado){
					return 'Categoría añadida con éxito';
				}else{
					return 'Error al añadir la categoría al campeonato';
				}
			}
		}
	}
  
	function QUITARCATEGORIA($Categoria){
		$sql = $this->mysqli->prepare("SELECT Comenzado FROM Campeonato WHERE Campeonato.Campeonato = ?");
		$sql->bind_param("i", $this->Campeonato);
		$sql->execute();
    
		$resultado = $sql->get_result();
		
		if(!$resultado){
			return 'No se ha podido conectar con la BD';
		}else if($resultado->num_rows != 1){
			return 'No se ha encontrado el campeonato';
		}else{
			$fila = $resultado->fetch_row();
			if($fila[0] == 1){
				return 'El campeonato ya ha comenzado, no puedes quitar una categoría';
			}
			
			$sql = $this->mysqli->prepare("SELECT * FROM campeonato_consta_de_categorias WHERE Campeonato_Campeonato = ? AND Categoria_Categoria = ?");
			$sql->bind_param("ii", $this->Campeonato, $Categoria);
			$sql->execute();
		
			$resultado = $sql->get_result();
		
			if(!$resultado){
				return 'No se ha podido conectar con la BD';
			}else if($resultado->num_rows == 0){
				return 'El campeonato no tiene la categoría';
			}else{
				$sql = $this->mysqli->prepare("DELETE FROM campeonato_consta_de_categorias WHERE Campeonato_Campeonato = ? AND Categoria_Categoria = ?");
				$sql->bind_param("ii", $this->Campeonato, $Categoria);
				$resultado = $sql->execute();
				
				if($resultado){
					return 'Categoría eliminada con éxito';
				}else{
					return 'Error al eliminar la categoría del campeonato';
				}
			}
		}
	}

	function CATEGORIASYCAMPEONATOS_UNSET(){ //horaios que no tenga pìst asignada
		$sql = $this->mysqli->prepare("	SELECT Campeonato.Campeonato, Campeonato.FechaInicio, Campeonato.FechaFinal, Campeonato.Nombre, Categoria.Categoria, Categoria.Nivel, Categoria.Sexo
										FROM Campeonato, Categoria WHERE Campeonato.Campeonato = ? 
											AND CONCAT(Campeonato.Campeonato,'', Categoria.Categoria) 
												NOT IN (SELECT CONCAT(Campeonato_consta_de_categorias.Campeonato_Campeonato,'',Campeonato_consta_de_categorias.Categoria_Categoria) FROM Campeonato_consta_de_categorias) 
										ORDER BY Campeonato.Campeonato, Categoria.Categoria;");
		$sql->bind_param("i", $this->Campeonato);
		$sql->execute();
		
		$resultado = $sql->get_result();
		
		if(!$resultado){
			return 'No se ha podido conectar con la BD';
		}else if($resultado->num_rows == 0){
			return 'No se han encontrado categorias no asignadas para el campeonato';
		}else{
			return $resultado;
		}
	}
	
	function GENERARCALENDARIO(){
		//Falta el check de si ya exiten grupos y enfrentamientos
		$sql = $this->mysqli->prepare("	SELECT Comenzado FROM Campeonato WHERE Campeonato = ?");
		$sql->bind_param("i", $this->Campeonato);
		$sql->execute();
    
		$campeonato = $sql->get_result();
		
		if($campeonato->fetch_row()[0]){
			return "No se puede generar el calendario de un campeonato que ya ha comenzado";
		}else{
			$sql = $this->mysqli->prepare("	UPDATE Campeonato SET Comenzado = 1 WHERE Campeonato = ?");
			$sql->bind_param("i", $this->Campeonato);
			$campeonato = $sql->execute();
		}
		
		$sql = $this->mysqli->prepare("	SELECT campeonato_consta_de_categorias.constadeCategorias, Categoria.Nivel, Categoria.Sexo FROM campeonato_consta_de_categorias, Categoria 
										WHERE Campeonato_Campeonato = ? AND campeonato_consta_de_categorias.Categoria_Categoria = Categoria.Categoria");
		$sql->bind_param("i", $this->Campeonato);
		$sql->execute();
    
		$categorias = $sql->get_result();
		
		$respuesta = array();
		
		while($categoria = $categorias->fetch_row()){
			//Para cada categoria, mirar los apuntados a la categoria y generar grupos y enfrentamientos
			$sql = $this->mysqli->prepare("	SELECT pareja_pertenece_categoria.perteneceCategoria, pareja_pertenece_categoria.Pareja_codPareja FROM pareja_pertenece_categoria, campeonato_consta_de_categorias, pareja_pertenece_categoria_de_campeonato
											WHERE campeonato_consta_de_categorias.Campeonato_Campeonato = ? AND campeonato_consta_de_categorias.Categoria_Categoria = ?
												AND campeonato_consta_de_categorias.constadeCategorias = pareja_pertenece_categoria_de_campeonato.CampeonatoConstadeCategorias 
												AND pareja_pertenece_categoria_de_campeonato.ParejaPerteneceCategoria = pareja_pertenece_categoria.perteneceCategoria
											ORDER BY pareja_pertenece_categoria_de_campeonato.parejaCategoriaCampeonato");
			$sql->bind_param("ii", $this->Campeonato, $categoria[0]);
			$sql->execute();
			
			$apuntados = $sql->get_result();
			
			$mensajeRespuesta = "";
			
			if(!$apuntados){
				$mensajeRespuesta = "No se ha podido conectar a la BD</br>";
			}else if($apuntados->num_rows < 8){
				$mensajeRespuesta = "No hay suficiente gente apuntada (" . $apuntados->num_rows . " persona/s registrada/s)</br>";
			}else{
				$paraGrupos = array();
				if($apuntados->num_rows > 32){
					$mensajeRespuesta = "Hay demasiados apuntados (más de 96), así que se cogeran a los primeros 96 apuntados</br>";
					for($i = 0; $i < 96; $i++){
						$fila = $apuntados->fetch_row();
						$auxIn = array($fila[0], $fila[1]);
						array_push($paraGrupos, $auxIn);
					}
				}else if($apuntados->num_rows % 12 < 8){
					$mensajeRespuesta = $mensajeRespuesta . "No hay suficientes personas para hacer un grupo de 8, así que se retiran las personas de exceso</br>";
					for($i = 0; $i < $apuntados->num_rows - $apuntados->num_rows % 12; $i++){
						$fila = $apuntados->fetch_row();
						$auxIn = array($fila[0],$fila[1]);
						array_push($paraGrupos, $auxIn);
					}
				}else{
					for($i = 0; $i < $apuntados->num_rows; $i++){
						$fila = $apuntados->fetch_row();
						$auxIn = array($fila[0], $fila[1]);
						array_push($paraGrupos, $auxIn);
					}
				}
				shuffle($paraGrupos);shuffle($paraGrupos);shuffle($paraGrupos);shuffle($paraGrupos);shuffle($paraGrupos); //Aleatoriedad
				
				$Grupo = array("A", "B", "C", "D", "E", "F", "G", "H");
				$GrupoNum = -1;
				//$categoria[0] CampeonatoCategoria $paraGrupos[$i][0] ParejaCategoria
				for($i = 0; $i < sizeof($paraGrupos); $i++){
					if($i % 12 == 0){
						$GrupoNum++;
					}
					$sql = $this->mysqli->prepare("	REPLACE INTO Grupo (nombre, CampeonatoCategoria, ParejaCategoria) VALUES (?, ?, ?)");
					$sql->bind_param("sii", $Grupo[$GrupoNum], $categoria[0], $paraGrupos[$i][0]);
					$resultado = $sql->execute();
					
					if(!$resultado){
						$mensajeRespuesta = $mensajeRespuesta . "Error al insertar en el grupo " . $Grupo[$GrupoNum] . " al deportista con DNI " . $paraGrupos[$i][1] . ", ya está registrado en el grupo</br>";
					}else{
						$mensajeRespuesta = $mensajeRespuesta . "Insertado en el grupo " . $Grupo[$GrupoNum] . " al deportista con DNI " . $paraGrupos[$i][1] . "</br>";
					}
				}
				
				$sql = $this->mysqli->prepare("	SELECT Grupo.nombre, Grupo.CampeonatoCategoria, pareja_pertenece_categoria.Pareja_codPareja FROM Grupo, pareja_pertenece_categoria 
												WHERE Grupo.CampeonatoCategoria = ? AND Grupo.ParejaCategoria = pareja_pertenece_categoria.perteneceCategoria
												ORDER BY Grupo.nombre");
				$sql->bind_param("i", $categoria[0]);
				$sql->execute();
				
				$apuntadosEnElCampeonato = $sql->get_result()->fetch_all();
				
				if(!$apuntadosEnElCampeonato){
						$mensajeRespuesta = $mensajeRespuesta . "No se ha podido conectar con la BD para generar los enfrentamientos</br>";
				}else if(sizeof($apuntadosEnElCampeonato) != sizeof($paraGrupos)){
						$mensajeRespuesta = $mensajeRespuesta . "Ha habido un error al insertar a los deportistas a los grupos, no se pueden generar los enfrentamientos</br>";
				}else{
					//Aquí se pone un array con los que conforman cada grupo
					$arrayGrupos = array();
					$auxArray = array();
					$prevGrupo = $apuntadosEnElCampeonato[0][0];
					array_push($auxArray, $prevGrupo);
					for($i = 0; $i < sizeof($apuntadosEnElCampeonato); $i++){
						if($apuntadosEnElCampeonato[$i][0] === $prevGrupo){
							array_push($auxArray, $apuntadosEnElCampeonato[$i][2]);
						}else{
							array_push($arrayGrupos, $auxArray);
							$prevGrupo = $apuntadosEnElCampeonato[$i][0];
							$auxArray = array();
							array_push($auxArray, $prevGrupo);
							array_push($auxArray, $apuntadosEnElCampeonato[$i][2]);
						}
					}
					if(!empty($auxArray)){
						array_push($arrayGrupos, $auxArray);
					}
					
					for($i = 0; $i < sizeof($arrayGrupos); $i++){
						$GrupoAGenerarEnfrentamientos = $arrayGrupos[$i][0];
						for($j = 1; $j < sizeof($arrayGrupos[$i]) - 1; $j++){
							$auxEnf = $j + 1;
							for($auxEnf; $auxEnf < sizeof($arrayGrupos[$i]); $auxEnf++){
								$sql = $this->mysqli->prepare("	INSERT INTO Enfrentamiento (nombre, CampeonatoCategoria, Pareja1, Pareja2, set1, set2,set3)
																VALUES (?, ?, ?, ?, '0-0', '0-0', '0-0');");
								$sql->bind_param("siss", $GrupoAGenerarEnfrentamientos, $categoria[0], $arrayGrupos[$i][$j], $arrayGrupos[$i][$auxEnf]);
								$confirmacionEnfrentamiento = $sql->execute();
							
								if(!$confirmacionEnfrentamiento){
									$mensajeRespuesta = $mensajeRespuesta . "Error al añadir el enfrentamiento entre " . $arrayGrupos[$i][$j] . " y " . $arrayGrupos[$i][$auxEnf] . "</br>";
								}else{
									$mensajeRespuesta = $mensajeRespuesta . "Añadido el enfrentamiento entre " . $arrayGrupos[$i][$j] . " y " . $arrayGrupos[$i][$auxEnf] . "</br>";
								}
							}
						}
					}
				}
				
				
			}
			
			$arrayRespuesta = array($categoria[1] . ' ' . $categoria[2] => $mensajeRespuesta);
			array_push($respuesta, $arrayRespuesta);
		}
		return $respuesta;
	}
	
	function GENERARCUARTOS(){
		$cuartos = 8;
		$stringCuartos = "Cuartos";
		$stringJugados = "Jugados";
		$stringGanados = "Ganados";
		$stringPerdidos = "Perdidos";
		$stringPuntos = "Puntos";
		$stringCapitan = "Capitan";
		$stringCompanhero = "Companhero";
		
		$respuesta = array();
		
		$categorias = $this->RANKINGGRUPOS();
		
		foreach ($categorias as $categoria => $grupos){
			$mensajeCategoria = "";
			$seleccionados = array();
			$contadorSeleccion = 0;
		
			//Coger ceiling(8/(numGrupos)) jugadores por grupo y poner por puntos del 1º al 8º, a partir de ahí generar los cuartos
			//var_dump(ceil(floatval(8)/floatval(3)));
			$sql = $this->mysqli->prepare("	SELECT COUNT(DISTINCT enfrentamiento.nombre) FROM enfrentamiento WHERE CampeonatoCategoria = ? AND nombre IS NOT NULL");
			$CampeonatoCategoria = intval(explode(":", $categoria)[0]);
			$sql->bind_param("i", $CampeonatoCategoria);
			$sql->execute();
		
			$numGrupos = $sql->get_result()->fetch_row()[0];
			
			if($numGrupos != 0){
				$numSeleccionadosPorGrupo = intval(ceil(floatval($cuartos)/floatval($numGrupos)));
			
				if(!is_string($grupos)){
					//Aquí habría que poner una condición de que cada grupo tenga suficiente gente, o coger de otro grupo si falta, o dejarlos en blanco
					foreach ($grupos as $grupo => $parejas){
						if(sizeof($parejas) < $numSeleccionadosPorGrupo){
							$mensajeCategoria = "No hay suficientes usuarios para hacer la fase de cuartos de " . explode(":", $categoria)[1] .  ", abortando";
							break;
						}
						usort($parejas, array($this, "usortCustom"));
						for($i = 0; $i < $numSeleccionadosPorGrupo; $i++){
							$seleccionados[$contadorSeleccion++] = $parejas[$i];
						}
					}
					usort($seleccionados, array($this, "usortCustom"));
					//Hora de generar los enfrentamientos
					if(sizeof($seleccionados) != $cuartos){
						$mensajeCategoria = "Error al seleccionar a los deportistas que pasan de grupos";
					}else{
						var_dump($seleccionados);
						for($i = 0; $i < sizeof($seleccionados)/2; $i++){
							$Pareja1 = $seleccionados[$i][$this->stringCodPareja];
							$Pareja2 = $seleccionados[sizeof($seleccionados) - $i - 1][$this->stringCodPareja];
							
							$sql = $this->mysqli->prepare("	REPLACE INTO Enfrentamiento (CampeonatoCategoria, Pareja1, Pareja2, set1, set2, set3, SegundaRonda) VALUES (?, ?, ?,'0-0', '0-0', '0-0', ?)");
							$sql->bind_param("issi", $CampeonatoCategoria, $Pareja1, $Pareja2, $this->codCuartos);
							
							$enfrentamientoInsertado = $sql->execute();
							
							if($enfrentamientoInsertado){
								$mensajeCategoria = $mensajeCategoria . "Enfrentamiento entre " . $Pareja1 . " y " . $Pareja2 . " generado con éxito</br>";
							}else{
								$mensajeCategoria = $mensajeCategoria . "Error al generar el enfrentamiento entre " . $Pareja1 . " y " . $Pareja2 . "</br>";
							}
						}
					}
				}else{
					$mensajeCategoria = $grupos;
				}
				
				if($mensajeCategoria === ''){
					$mensajeCategoria = "Fase de cuartos generada sin problemas";
				}
			}else{
				if(!is_string($grupos)){
					$mensajeCategoria = "No se ha generado el calendario del campeonato";
				}else{
					$mensajeCategoria = $grupos;
				}
			}
			
			$respuesta[$categoria] = $mensajeCategoria;
		}
		
		return $respuesta;
	}
	
	function usortCustom($a, $b){
		$strJugados = "Jugados";
		$strPuntos = "Puntos";
		if ($a[$strPuntos] == $b[$strPuntos]) {
			if ($a[$strJugados] == $b[$strJugados]) {
				return 0;
			}else{
				return ($a[$strJugados] < $b[$strJugados]) ? 1 : -1;
			}
		}
		
		return ($a[$strPuntos] < $b[$strPuntos]) ? 1 : -1;
	}
	
	function RANKINGGRUPOS(){
		$sql = $this->mysqli->prepare("	SELECT campeonato_consta_de_categorias.constadeCategorias, Categoria.Nivel, Categoria.Sexo FROM campeonato_consta_de_categorias, Categoria 
										WHERE Campeonato_Campeonato = ? AND campeonato_consta_de_categorias.Categoria_Categoria = Categoria.Categoria");
		$sql->bind_param("i", $this->Campeonato);
		$sql->execute();
    
		$categorias = $sql->get_result();
		
		$respuesta = array();
		
		while($categoria = $categorias->fetch_row()){
			$sql = $this->mysqli->prepare("	SELECT Enfrentamiento.nombre, Enfrentamiento.Pareja1, Enfrentamiento.Pareja2, Enfrentamiento.set1, Enfrentamiento.set2, Enfrentamiento.set2
											FROM Enfrentamiento WHERE Enfrentamiento.CampeonatoCategoria = ? AND Enfrentamiento.nombre IS NOT NULL");
			$sql->bind_param("i", $categoria[0]);
			$sql->execute();
		
			$participantes = $sql->get_result();
			$arrayGrupo = array();
			
			for($i = 0; $i < $participantes->num_rows; $i++){
				$fila = $participantes->fetch_row();
				$Grupo = $fila[0];
				$Pareja1 = $fila[1];
				$Pareja2 = $fila[2];
				$set1 = $fila[3];
				$set2 = $fila[4];
				$set3 = $fila[5];
				
				//$ParejaX => array("Jugados" => x, "Ganados" => x, "Perdidos" => x, "Puntos" => x);
				if($this->ganadorDe($set1) + $this->ganadorDe($set2) + $this->ganadorDe($set3) < 0){
					if(!array_key_exists($Grupo, $arrayGrupo)){
						$arrayGrupo[$Grupo] = array();
					}
					
					$arrayGrupo[$Grupo] = $this->sumarEstadisticas($Pareja1, $Pareja2, $arrayGrupo[$Grupo]);
				}else if($this->ganadorDe($set1) + $this->ganadorDe($set2) + $this->ganadorDe($set3) > 0){
					if(!array_key_exists($Grupo, $arrayGrupo)){
						$arrayGrupo[$Grupo] = array();
					}
					
					$arrayGrupo[$Grupo] = $this->sumarEstadisticas($Pareja2, $Pareja1, $arrayGrupo[$Grupo]);
				}else{
					//Si se quisiera poner aquí se añadirían los deportistas apuntados pero que no han jugado ningún partido a la clasificación
					if(!array_key_exists($Grupo, $arrayGrupo)){
						$arrayGrupo[$Grupo] = array();
					}
					
					$arrayGrupo[$Grupo] = $this->sumarEstadisticas($Pareja2, $Pareja1, $arrayGrupo[$Grupo]);
				}
			}
			if(empty($arrayGrupo)){
				$respuesta[$categoria[0] . ':' . $categoria[1] . ' ' . $categoria[2]] = "No hay enfrentamientos o no se han jugado para la categoría";
			}else{
				$respuesta[$categoria[0] . ':' . $categoria[1] . ' ' . $categoria[2]] = $arrayGrupo;
			}
		}
		return $respuesta;
	}
	
	function ganadorDe($set){
		if(substr($set, 0, 1) === '6' || substr($set, 0, 1) != '0'){
			return -1;
		}else if(substr($set, 2, 1) === '6' || substr($set, 2, 1) != '0'){
			return 1;
		}else{
			return 0;
		}
	}
	
	function sumarEstadisticas($Ganador, $Perdedor, $array){
		$stringJugados = "Jugados";
		$stringGanados = "Ganados";
		$stringPerdidos = "Perdidos";
		$stringPuntos = "Puntos";
		$stringCapitan = "Capitan";
		$stringCompanhero = "Companhero";
		/**GANADOR**/
		if(array_key_exists($Ganador, $array)){
			$array[$Ganador][$stringJugados]++;
			$array[$Ganador][$stringGanados]++;
			$array[$Ganador][$stringPuntos] += 4;
		}else{
			$array[$Ganador] = array($stringJugados => 1, $stringGanados => 1, $stringPerdidos => 0, $stringPuntos => 4);
			
			$sqlCap = $this->mysqli->prepare("	SELECT Deportista.nombre, Deportista.Apellidos FROM Deportista, Pareja WHERE Pareja.codPareja = ? AND Pareja.DNI_Capitan = Deportista.DNI");
			$sqlCap->bind_param("s", $Ganador);
			$sqlCap->execute();
		
			$DNI_Capitan = $sqlCap->get_result();
			
			$sqlCop = $this->mysqli->prepare("	SELECT Deportista.nombre, Deportista.Apellidos FROM Deportista, Pareja WHERE Pareja.codPareja = ? AND Pareja.DNI_Companhero = Deportista.DNI");
			$sqlCop->bind_param("s", $Ganador);
			$sqlCop->execute();
		
			$DNI_Companhero = $sqlCop->get_result();
			if($DNI_Capitan != null){
				$fila = $DNI_Capitan->fetch_row();
				$array[$Ganador][$stringCapitan] = $fila[0] . ' ' . $fila[1];
			}
			if($DNI_Companhero != null){
				$fila = $DNI_Companhero->fetch_row();
				$array[$Ganador][$stringCompanhero] = $fila[0] . ' ' . $fila[1];
			}
			$array[$Ganador][$this->stringCodPareja] = $Ganador;
		}
		
		/**PERDEDOR**/
		if(array_key_exists($Perdedor, $array)){
			$array[$Perdedor][$stringJugados]++;
			$array[$Perdedor][$stringPerdidos]++;
			$array[$Perdedor][$stringPuntos] += 1;
		}else{
			$array[$Perdedor] = array($stringJugados => 1, $stringGanados => 0, $stringPerdidos => 1, $stringPuntos => 1);
			
			$sqlCap = $this->mysqli->prepare("	SELECT Deportista.nombre, Deportista.Apellidos FROM Deportista, Pareja WHERE Pareja.codPareja = ? AND Pareja.DNI_Capitan = Deportista.DNI");
			$sqlCap->bind_param("s", $Perdedor);
			$sqlCap->execute();
		
			$DNI_Capitan = $sqlCap->get_result();
			
			$sqlCop = $this->mysqli->prepare("	SELECT Deportista.nombre, Deportista.Apellidos FROM Deportista, Pareja WHERE Pareja.codPareja = ? AND Pareja.DNI_Companhero = Deportista.DNI");
			$sqlCop->bind_param("s", $Perdedor);
			$sqlCop->execute();
		
			$DNI_Companhero = $sqlCop->get_result();
			if($DNI_Capitan != null){
				$fila = $DNI_Capitan->fetch_row();
				$array[$Perdedor][$stringCapitan] = $fila[0] . ' ' . $fila[1];
			}
			if($DNI_Companhero != null){
				$fila = $DNI_Companhero->fetch_row();
				$array[$Perdedor][$stringCompanhero] = $fila[0] . ' ' . $fila[1];
			}
			$array[$Perdedor][$this->stringCodPareja] = $Perdedor;
		}
		
		return $array;
	}

}
?>
