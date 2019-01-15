<?php

class Campeonato_consta_de_categorias

{
	var $constadeCategorias;
  	var $Campeonato_Campeonato;
 	var $Categoria_Categoria;
  	var $mysqli;

    

	function __construct($constadeCategorias,$Campeonato_Campeonato,$Categoria_Categoria)
  {
  		$this ->constadeCategorias=$constadeCategorias;
  		$this ->Campeonato_Campeonato = $Campeonato_Campeonato;
  		$this ->Categoria_Categoria = $Categoria_Categoria;
  	  		include_once '../Functions/ConectarBD.php'; //Actualizar
		$this->mysqli = ConectarBD();
	}

	public function getConstadeCategorias() {
    return $this ->constadeCategorias;
  }

  public function getCampeonato_Campeonato() {
    return $this ->Campeonato_Campeonato;
  }

  public function getCategoria_Categoria() {
    return $this ->Categoria_Categoria;
  }
 
 
   public function setConstadeCategorias($constadeCategorias) {
    $this ->constadeCategorias=$constadeCategorias;
    
  }
  public function setCampeonato_Campeonato($Campeonato_Campeonato) {
   $this ->Campeonato_Campeonato=$Campeonato_Campeonato;
  }

  public function setCategoria_Categoria($Categoria_Categoria) {
    $this ->Categoria_Categoria=$Categoria_Categoria;
  }

   function _getDatosGuardados(){//Para recuperar de la base de datos
    if(($this->constadeCategorias() == '')){
      return 'Codigo vacio.';
    }else{
      $sql = $this->mysqli->prepare("SELECT * FROM Campeonato_consta_de_categorias WHERE constadeCategorias = ?");
      $sql->bind_param("i", $this->constadeCategorias);
      $sql->execute();
      
      $resultado = $sql->get_result();
      
      if(!$resultado){
        return 'No se ha podido conectar con la BD';
      }else if($resultado->num_rows == 0){
        return 'No existe la pareja de esa categoria';
      }else{
        $fila = $resultado->fetch_row();
        
        $this->_setCampeonato_Campeonato($fila[1]);
        $this->_setCategoria_Categoria($fila[2]);
      }
    }
  }

   function _getCodigo($campeonato,$categoria){
   	 if(($this->constadeCategorias == '')){
      
      $sql = $this->mysqli->prepare("SELECT * FROM Campeonato_consta_de_categorias WHERE Campeonato_Campeonato = ? AND Categoria_Categoria = ?");
      $sql->bind_param("ii", $campeonato,$categoria);
      $sql->execute();
      
      $resultado = $sql->get_result();
      
      if(!$resultado){
        return 'No se ha podido conectar con la BD';
      }else if($resultado->num_rows == 0){
        return 'No existe el campeonato con esas categorias';
      }else{
        $fila = $resultado->fetch_row();
        $this->setConstadeCategorias($fila[0]);
      }
    }else{
    	return "no hay campeonato o categoria especificada";
    }
   }
  
  

   function ADD(){//Para añadir a la BD
		$sql = $this->mysqli->prepare("INSERT INTO Campeonato_consta_de__categorias (Campeonato_Campeonato, Categoria_Categoria) VALUES (?,?)");
		$sql->bind_param("si", $this->Campeonato_Campeonato, $this->Categoria_Categoria);
		
		
		$resultado = $sql->execute();
	
		if(!$resultado){
			return 'Ha fallado insertar la categoria en el campeonato';
		}else{
			return 'Inserción correcta';
		}
	}
	
	/*function EDIT(){//Para editar de la BD
	}*/
	
	function SEARCH(){
		$sql = $this->mysqli->prepare("SELECT * FROM Campeonato_consta_de_categorias WHERE ((Campeonato_Campeonato LIKE ?) AND (Categoria_Categoria LIKE ?)");
		$sql->bind_param("si", '%' + $this->getCampeonato_Campeonato() + '%', '%' + $this->getCategoria_Categoria() + '%'); 
		$sql->execute();
		
		$resultado = $sql->fetch();
		
		if(!$resultado || $resultado->num_rows == 0){
			return 'No se ha encontrado ningun dato';
		}else{
			return $resultado;
		}
	}
	
	function DELETE(){//Para eliminar de la BD
		$sql = $this->mysqli->prepare("SELECT * FROM Campeonato_consta_de_categorias WHERE ((Campeonato_Campeonato = ?) AND (Categoria_Categoria = ?))");
		$sql->bind_param("si", $this->getCampeonato_Campeonato(), $this->getCategoria_Categoria());
		$sql->execute();
		
		$resultado = $sql->fetch();
		
		if(!$resultado){
			return 'No se ha podido conectar con la BD';
		}else if($resultado->num_rows == 0){
			return 'No se ha encontrado la pista y horario';
		}else{
			$sql = $this->mysqli->prepare("DELETE FROM Campeonato_consta_de_categorias WHERE ((Campeonato_Campeonato = ?) AND (Categoria_Categoria = ?))");
			$sql->bind_param("si", $this->getCampeonato_Campeonato(), $this->getCategoria_Categoria());
			$sql->execute();
			
			$resultado = $sql->fetch();
		
			if(!$resultado){
				return 'Fallo al eliminar la tupla';
			}else{
				return 'categoria y campeonatos eliminados correctamente';
			}
		}
	}
	
	function SHOWALL(){//Para mostrar la BD
		$sql = "SELECT * FROM Campeonato_consta_de_categorias";
		
		$resultado = $this->mysqli->query($sql);
		
		if(!$resultado){
			return 'No se ha podido conectar con la BD';
		}else{
			return $resultado;
		}
	}
}