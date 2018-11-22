<?php

class Pareja_pertenece_categoria

{
	var $perteneceCategoria;
  	var $Pareja_codPareja;
 	var $Categoria_Categoria;
  	var $mysqli;

    

	function __construct($perteneceCategoria,$Pareja_codPareja,$Categoria_Categoria)
  {
  		$this ->perteneceCategoria=$perteneceCategoria
  		$this ->Pareja_codPareja = $Pareja_codPareja;
  		$this ->Categoria_Categoria = $Categoria_Categoria;
  	  		include_once '../Functions/ConectarBD.php'; //Actualizar
		$this->mysqli = ConectarBD();
	}

	public function getPerteneceCategoria() {
    return $this ->perteneceCategoria;
  }

  public function getPareja_codPareja() {
    return $this ->Pareja_codPareja;
  }

  public function getCategoria_Categoria() {
    return $this ->Categoria_Categoria;
  }
 
 
   public function setPareja_codPareja($Pareja_codPareja) {
    return $this ->Pareja_codPareja;
    
  }
  public function setCategoria_Categoria($Categoria_Categoria) {
    return $this ->Categoria_Categoria;
  }

  public function setPerteneceCategoria($perteneceCategoria) {
    return $this ->perteneceCategoria;
  }

   function ADD(){//Para añadir a la BD
		$sql = $this->mysqli->prepare("INSERT INTO Pareja_pertenece_categoria (Pareja_codPareja, Categoria_Categoria) VALUES (?,?)");
		$sql->bind_param("si", $this->getPareja_codPareja(), $this->getCategoria_Categoria());
		$sql->execute();
		
		$resultado = $sql->fetch();
	
		if(!$resultado){
			return 'Ha fallado insertar la categoria en el campeonato';
		}else{
			return 'Inserción correcta';
		}
	}
	
	/*function EDIT(){//Para editar de la BD
	}*/
	
	function SEARCH(){
		$sql = $this->mysqli->prepare("SELECT * FROM Pareja_pertenece_categoria WHERE ((Pareja_codPareja LIKE ?) AND (Categoria_Categoria LIKE ?)");
		$sql->bind_param("si", '%' + $this->getPareja_codPareja() + '%', '%' + $this->getCategoria_Categoria() + '%'); 
		$sql->execute();
		
		$resultado = $sql->fetch();
		
		if(!$resultado || $resultado->num_rows == 0){
			return 'No se ha encontrado ningun dato';
		}else{
			return $resultado;
		}
	}
	
	function DELETE(){//Para eliminar de la BD
		$sql = $this->mysqli->prepare("SELECT * FROM Pareja_pertenece_categoria WHERE ((Pareja_codPareja = ?) AND (Categoria_Categoria = ?))");
		$sql->bind_param("si", $this->getPareja_codPareja(), $this->getCategoria_Categoria());
		$sql->execute();
		
		$resultado = $sql->fetch();
		
		if(!$resultado){
			return 'No se ha podido conectar con la BD';
		}else if($resultado->num_rows == 0){
			return 'No se ha encontrado la pista y horario';
		}else{
			$sql = $this->mysqli->prepare("DELETE FROM Pareja_pertenece_categoria WHERE ((Pareja_codPareja = ?) AND (Categoria_Categoria = ?))");
			$sql->bind_param("si", $this->getPareja_codPareja(), $this->getCategoria_Categoria());
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
		$sql = "SELECT * FROM Pareja_pertenece_categoria";
		
		$resultado = $this->mysqli->query($sql);
		
		if(!$resultado){
			return 'No se ha podido conectar con la BD';
		}else{
			return $resultado;
		}
	}