<?php

class Pareja_pertenece_categoria_de_campeonato

{
	var $CampeonatoConstaCategoria;
  	var $ParejaPerteneceCategoria;
 	var $parejaCategoriaCampeonato;
  	var $mysqli;

    

	function __construct($parejaCategoriaCampeonato,$CampeonatoConstaCategoria,$ParejaPerteneceCategoria)
  {
  		$this ->parejaCategoriaCampeonato=$parejaCategoriaCampeonato;
  		$this ->CampeonatoConstaCategoria=$CampeonatoConstaCategoria;
  		$this ->ParejaPerteneceCategoria=$ParejaPerteneceCategoria;
  	  		include_once '../Functions/ConectarBD.php'; //Actualizar
		$this->mysqli = ConectarBD();
	}

	public function getParejaCategoriaCampeonato() {
    return $this ->parejaCategoriaCampeonato;
  }

  public function getCampeonatoConstaCategoria() {
    return $this ->CampeonatoConstaCategoria;
  }

  public function getParejaPerteneceCategoria() {
    return $this ->ParejaPerteneceCategoria;
  }
 
 
   public function setParejaCategoriaCampeonato($parejaCategoriaCampeonato) {
    return $this ->parejaCategoriaCampeonato;
    
  }
  public function setCampeonatoConstaCategoria($CampeonatoConstaCategoria) {
    return $this ->CampeonatoConstaCategoria;
  }

  public function setParejaPerteneceCategoria($ParejaPerteneceCategoria) {
    return $this ->ParejaPerteneceCategoria;
  }

   function ADD(){//Para añadir a la BD
		$sql = $this->mysqli->prepare("INSERT INTO Pareja_pertenece_categoria_de_campeonato (CampeonatoConstaCategoria,ParejaPerteneceCategoria) VALUES (?,?)");
		$sql->bind_param("si", $this->getCampeonatoConstaCategoria(), $this->getParejaPerteneceCategoria());
		$sql->execute();
		
		$resultado = $sql->fetch();
	
		if(!$resultado){
			return 'Ha fallado insertar la pareja en la categoria del campeonato';
		}else{
			return 'Inserción correcta';
		}
	}
	
	/*function EDIT(){//Para editar de la BD
	}*/
	
	function SEARCH(){
		$sql = $this->mysqli->prepare("SELECT * FROM Pareja_pertenece_categoria_de_campeonato WHERE ((CampeonatoConstaCategoria LIKE ?) AND (ParejaPerteneceCategoria LIKE ?)");
		$sql->bind_param("si", '%' + $this->getCampeonatoConstaCategoria() + '%', '%' + $this->getParejaPerteneceCategoria() + '%'); 
		$sql->execute();
		
		$resultado = $sql->fetch();
		
		if(!$resultado || $resultado->num_rows == 0){
			return 'No se ha encontrado ningun dato';
		}else{
			return $resultado;
		}
	}
	
	function DELETE(){//Para eliminar de la BD
		$sql = $this->mysqli->prepare("SELECT * FROM Pareja_pertenece_categoria_de_campeonato WHERE ((CampeonatoConstaCategoria = ?) AND (ParejaPerteneceCategoria = ?))");
		$sql->bind_param("si", $this->getCampeonatoConstaCategoria(), $this->getParejaPerteneceCategoria());
		$sql->execute();
		
		$resultado = $sql->fetch();
		
		if(!$resultado){
			return 'No se ha podido conectar con la BD';
		}else if($resultado->num_rows == 0){
			return 'No se ha encontrado la pareja de esa categoria de campeonato';
		}else{
			$sql = $this->mysqli->prepare("DELETE FROM Pareja_pertenece_categoria_de_campeonato WHERE ((CampeonatoConstaCategoria = ?) AND (ParejaPerteneceCategoria = ?))");
			$sql->bind_param("si", $this->getCampeonatoConstaCategoria(), $this->getParejaPerteneceCategoria());
			$sql->execute();
			
			$resultado = $sql->fetch();
		
			if(!$resultado){
				return 'Fallo al eliminar la tupla';
			}else{
				return 'pareja de esa categoria y campeonato eliminada correctamente';
			}
		}
	}
	
	function SHOWALL(){//Para mostrar la BD
		$sql = "SELECT * FROM Pareja_pertenece_categoria_de_campeonato";
		
		$resultado = $this->mysqli->query($sql);
		
		if(!$resultado){
			return 'No se ha podido conectar con la BD';
		}else{
			return $resultado;
		}
	}