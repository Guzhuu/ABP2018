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
    $this ->parejaCategoriaCampeonato=$parejaCategoriaCampeonato;
    
  }
  public function setCampeonatoConstaCategoria($CampeonatoConstaCategoria) {
    $this ->CampeonatoConstaCategoria=$CampeonatoConstaCategoria;
  }

  public function setParejaPerteneceCategoria($ParejaPerteneceCategoria) {
    $this ->ParejaPerteneceCategoria=$ParejaPerteneceCategoria;
  }


 function _getCodigo($campeonatoCategoria,$parejaCategoria){
   	 if(($this->parejaCategoriaCampeonato == '')){
      
      $sql = $this->mysqli->prepare("SELECT * FROM Pareja_pertenece_categoria_de_campeonato WHERE CampeonatoConstadeCategorias = ? AND ParejaPerteneceCategoria = ?");
      $sql->bind_param("si", $campeonatoCategoria,$parejaCategoria);
      $sql->execute();
      
      $resultado = $sql->get_result();
      
      if(!$resultado){
        return 'No se ha podido conectar con la BD';
      }else if($resultado->num_rows == 0){
        return 'No existe la pareja de esa categoria';
      }else{
        $fila = $resultado->fetch_row();
        $this->setParejaCategoriaCampeonato($fila[0]);
      }
    }else{
    	return "no hay pareja o campeonato de esa categoria especificada";
    }
   }
  

   function ADD(){//Para añadir a la BD
		$sql = $this->mysqli->prepare("INSERT INTO Pareja_pertenece_categoria_de_campeonato (CampeonatoConstadeCategorias,ParejaPerteneceCategoria) VALUES (?,?)");
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
		$sql = $this->mysqli->prepare("SELECT * FROM Pareja_pertenece_categoria_de_campeonato WHERE ((CampeonatoConstadeCategorias LIKE ?) AND (ParejaPerteneceCategoria LIKE ?)");
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
		$sql = $this->mysqli->prepare("SELECT * FROM Pareja_pertenece_categoria_de_campeonato WHERE ((CampeonatoConstadeCategorias = ?) AND (ParejaPerteneceCategoria = ?))");
		$sql->bind_param("si", $this->getCampeonatoConstaCategoria(), $this->getParejaPerteneceCategoria());
		$sql->execute();
		
		$resultado = $sql->fetch();
		
		if(!$resultado){
			return 'No se ha podido conectar con la BD';
		}else if($resultado->num_rows == 0){
			return 'No se ha encontrado la pareja de esa categoria de campeonato';
		}else{
			$sql = $this->mysqli->prepare("DELETE FROM Pareja_pertenece_categoria_de_campeonato WHERE ((CampeonatoConstadeCategorias = ?) AND (ParejaPerteneceCategoria = ?))");
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
}