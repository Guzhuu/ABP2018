<?php

class Campeonato_consta_de_categorias

{
	var $constaDeCategorias;
  	var $Campeonato_Campeonato;
  	var $Categoria_Categoria;
  	var $mysqli;
    

	function __construct($constaDeCategorias,$Campeonato_Campeonato,$Categoria_Categoria)
  {
  		$this ->constaDeCategorias = $constaDeCategorias;
  		$this ->Campeonato_Campeonato = $Campeonato_Campeonato;
  		$this ->Categoria_Categoria = $Categoria_Categoria;
  		include_once '../Functions/ConectarBD.php'; //Actualizar
		$this->mysqli = ConectarBD();
  	  		
	}
	public function getConstaDeCategorias() {
    return $this ->constaDeCategorias;
  }

  	public function getCampeonato_Campeonato() {
    return $this ->Campeonato_Campeonato;
  }

  	public function getCategoria_Categoria() {
    return $this ->Categoria_Categoria;
  }
 
  	public function setConstaDeCategorias($constaDeCategorias) {
    return $this ->constaDeCategorias;
  }
   	public function setCampeonato_Campeonato($Campeonato_Campeonato) {
    return $this ->Campeonato_Campeonato;
  }
 	 public function setCategoria_Categoria($Categoria_Categoria) {
    return $this ->Categoria_Categoria;
  }
function ADD(){//Para añadir a la BD
		$sql = $this->mysqli->prepare("INSERT INTO Campeonato_consta_de_categorias (Campeonato_Campeonato, Categoria_Categoria) VALUES (?,?)");
		
			$sql->bind_param("ii", $this->Campeonato_Campeonato, $this->Categoria_Categoria);
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
		$sql = $this->mysqli->prepare("SELECT * FROM Campeonato_consta_de_categorias WHERE ((Campeonato_Campeonato LIKE ?) AND (Categoria_Categoria LIKE ?)");
		$sql->bind_param("ii", '%' + $this->getCampeonato_Campeonato() + '%', '%' + $this->getCategoria_Categoria() + '%'); 
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
		$sql->bind_param("ii", $this->getCampeonato_Campeonato(), $this->getCategoria_Categoria());
		$sql->execute();
		
		$resultado = $sql->fetch();
		
		if(!$resultado){
			return 'No se ha podido conectar con la BD';
		}else if($resultado->num_rows == 0){
			return 'No se ha encontrado la pista y horario';
		}else{
			$sql = $this->mysqli->prepare("DELETE FROM Campeonato_consta_de_categorias WHERE ((Campeonato_Campeonato = ?) AND (Categoria_Categoria = ?))");
			$sql->bind_param("ii", $this->getCampeonato_Campeonato(), $this->getCategoria_Categoria());
			$sql->execute();
			
			$resultado = $sql->fetch();
		
			if(!$resultado){
				return 'Fallo al eliminar la tupla';
			}else{
				return 'categoria y campeonatos eliminados correctamente';
			}
		}
	}

function CATEGORIASYCAMPEONATOS_UNSET(){ //horaios que no tenga pìst asignada
		$sql = $this->mysqli->prepare("	SELECT Campeonato.Campeonato, Campeonato.FechaInicio, Campeonato.FechaFinal, Campeonato.Nombre, Categoria.Categoria, Categoria.Nivel, Categoria.Sexo

										FROM Campeonato, Categoria WHERE Campeonato.Campeonato = ? 
											AND CONCAT(Campeonato.Campeonato,'', Categoria.Categoria) 
												NOT IN (SELECT CONCAT(Campeonato_consta_de_categorias.Campeonato_Campeonato,'',Campeonato_consta_de_categorias.Categoria_Categoria) FROM Campeonato_consta_de_categorias) 
										ORDER BY Campeonato.Campeonato, Categoria.Categoria;");
		$sql->bind_param("i", $this->Campeonato_Campeonato);
		$sql->execute();
		
		$resultado = $sql->get_result();
		
		if(!$resultado){
			return 'No se ha podido conectar con la BD';
		}else if($resultado->num_rows == 0){
			return 'No se han encontrado categorias libres para el campeonato';
		}else{
			return $resultado;
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