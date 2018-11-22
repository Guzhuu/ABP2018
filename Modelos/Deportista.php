<?php


// file: model/ExerciseMapper.php
//require_once(__DIR__."/../core/PDOConnection.php");

//require_once(__DIR__."/../model/User.php");
//require_once(__DIR__."/../model/Ejercicio.php");



class Deportista
{
  public $dni;
  public $edad;
  public $nombre;
  public $apellidos;
  public $sexo;
  public $Contrasenha;
  public $cuota_socio;
  public $rolAdmin;
  public $rolEntrenador;
  private $db;
  private $mysqli;

	function __construct($DNI,$Edad,$Nombre,$Apellidos,$Sexo,$Contrasenha,$Cuota_socio,$rolAdmin,$rolEntrenador)
  {
  		$this->DNI = $DNI;
  		$this->Edad = $Edad;
  		$this->Nombre = $Nombre;
  		$this->Apellidos = $Apellidos;
  		$this->Sexo = $Sexo;
  		$this->Contrasenha = $Contrasenha;
  		$this->Cuota_socio = $Cuota_socio;
  		$this->rolAdmin = $rolAdmin;
  		$this->rolEntrenador = $rolEntrenador;
      //$this->db = PDOConnection::getInstance();
		include_once '../Functions/ConectarBD.php'; //Actualizar
		$this->mysqli = ConectarBD();
		
	}

  public function getDNI() {
    return $this->DNI;
  }

  public function getEdad() {
    return $this->Edad;
  }
  public function getNombre() {
    return $this->Nombre;
  }

  public function getApellidos() {
    return $this->Apellidos;
  }
  public function getSexo() {
    return $this->Sexo;
  }
  public function getContrasenha() {
    return $this->Contrasenha;
  }
  public function getCuotaSocio() {
    return $this->Cuota_socio;
  }
  public function getRolAdmin() {
    return $this->rolAdmin;
  }
  public function getRolEntrenador() {
    return $this->rolEntrenador;
  }    


  public function setDNI ($DNI){
    $this->DNI = $DNI;
  }

  public function setEdad ($Edad){
    $this->Edad = $Edad;
  }
  public function setNombre($Nombre){
	  $this->Nombre;
  }

  public function setApellidos ($Apellidos){
    $this->Apellidos = $Apellidos;
  }

  public function setSexo ($Sexo){
    $this->Sexo = $Sexo;
  }

  public function setContrasenha ($Contrasenha){
    $this->Contrasenha = $Contrasenha;
  }

  public function setCuotaSocio ($Cuota_socio){
    $this->Cuota_socio = $Cuota_socio;
  }

  public function setRolAdmin ($rolAdmin){
    $this->rolAdmin = $rolAdmin;
  } 
  public function setRolEntrenador ($rolEntrenador){
    $this->rolEntrenador = $rolEntrenador;
  }  


	public function comprobarDatos() {
			$errors = array();

			if (strlen(trim($this->id)) == 0 ) {
				$errors["id"] = "El ID no es válido";
			}

			if (strlen($this->duracion) == 0) {
				$errors["edad"] = "La tabla debe tener duración.";
			}

			if (sizeof($errors)>0){
				throw new ValidationException($errors, "Existen errores. No se puede registrar la tabla.");
			}
	}



/*
  public function findAll() {
    $stmt = $this->db->query("SELECT * FROM Deportista");
    $deportistas_db = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $deportistas = array();

    foreach ($deportistas_db as $deportista) {
      array_push($deportistas, new Deportista($deportista["DNI"],$deportista["Edad"], $deportista["Nombre"], $deportista["Apellidos"]
      , $deportista["Sexo"], $deportista["Contrasenha"], $deportista["Cuota_socio"], $deportista["rolAdmin"], $deportista["rolEntrenador"]));
    }

    return $deportistas;
  }


  public function findByDNI($DNI){
    $stmt = $this->db->prepare("SELECT * FROM Deportista WHERE DNI=?");
    $stmt->execute(array($DNI));
    $deportista = $stmt->fetch(PDO::FETCH_ASSOC);

    if($deportista != null) {
      return new Deportista($deportista["DNI"],
        $deportista["Edad"],
        $deportista["Nombre"],
        $deportista["Apellidos"],
        $deportista["Sexo"],
        $deportista["Contrasenha"],
        $deportista["Cuota_socio"],
        $deportista["rolAdmin"],
        $deportista["rolEntrenador"]);
    } else {
      return NULL;
    }
  }
/*
  public function findByEscuela($codigoEscuela){
    $stmt = $this->db->prepare("SELECT * FROM Clase WHERE codigoEscuela=?");
    $stmt->execute(array($codigoEscuela));
    $deportista = $stmt->fetch(PDO::FETCH_ASSOC);

    if($deportista != null) {
      return new Clase(
      $deportista["Clase"],
      $deportista["Reserva_Reserva"],
      $deportista["codigoEscuela"],
      $deportista["Entrenador"]);
    } else {
      return NULL;
    }
  }

  public function findByEntrenador($dniEntrenador){
    $stmt = $this->db->prepare("SELECT * FROM Clase WHERE Entrenador=?");
    $stmt->execute(array($dniEntrenador));
    $deportista = $stmt->fetch(PDO::FETCH_ASSOC);

    if($deportista != null) {
      return new Clase(
      $deportista["Clase"],
      $deportista["Reserva_Reserva"],
      $deportista["codigoEscuela"],
      $deportista["Entrenador"]);
    } else {
      return NULL;
    }
  }

  public function exists($DNI){
    $stmt = $this->db->prepare("SELECT * FROM Deportista WHERE DNI=?");
    $stmt->execute(array($DNI));
    $deportista = $stmt->fetch(PDO::FETCH_ASSOC);

    if($deportista != null) {
      return true;
    } else {
      return false;
    }
  }


    public function save(Deportista $deportista) {
      $stmt = $this->db->prepare("INSERT INTO Deportista(DNI, Edad, Nombre, Apellidos, Sexo, Contrasenha, Cuota_socio, rolAdmin, rolEntrenador) values (?,?,?,?,?,?,?,?,?)");
      $stmt->execute(array($deportista->getDNI(), $deportista->getEdad(), $deportista->getNombre(),$deportista->getApellidos(),$deportista->getSexo()
        ,$deportista->getContrasenha(),$deportista->getCuotaSocio(),$deportista->getRolAdmin(),$deportista->getRolEntrenador()));
      return $this->db->lastInsertId();
    }


    public function update(Deportista $deportista) {
      $stmt = $this->db->prepare("UPDATE Deportista set DNI=?, Edad=?, Nombre=?, Apellidos=?, Sexo=?, Contrasenha=?, Cuota_socio=?,rolAdmin=?,rolEntrenador=? where DNI=?");
      $stmt->execute(array($deportista->getDNI(), $deportista->getEdad(), $deportista->getNombre(),$deportista->getApellidos(),$deportista->getSexo()
        ,$deportista->getContrasenha(),$deportista->getCuotaSocio(),$deportista->getRolAdmin(),$deportista->getRolEntrenador()));
    }

    public function delete(Deportista $deportista) {
      $stmt = $this->db->prepare("DELETE from Deportista WHERE Deportista=?");
      $stmt->execute(array($deportista->getDNI()));
    }
	*/
	
	function LOGIN(){
		$sql = $this->mysqli->prepare("SELECT Contrasenha FROM deportista WHERE DNI = ?");
		$sql->bind_param("i", $this->DNI);
		$sql->execute();
		
		$resultado = $sql->get_result();
		
		if(!$resultado){
			return 'No se ha podido conectar con la BD';
		}else if($resultado->num_rows == 0 /* || $resultado->fetch_row()[0] == ''*/){
			return 'DNI incorrecto';
		}else{
			if($this->Contrasenha === $resultado->fetch_row()[0]){
				return 'true';
			}else{
				return 'Contraseña incorrecta';
			}
		}
	}
	
	function ADMIN(){
		$sql = $this->mysqli->prepare("SELECT rolAdmin FROM deportista WHERE DNI = ?");
		$sql->bind_param("i", $this->DNI);
		$sql->execute();
		
		$resultado = $sql->get_result();
		
		if(!$resultado){
			return 'No se ha podido conectar con la BD';
		}else if($resultado->num_rows == 0){
			return false;
		}else{
			if($resultado->fetch_assoc()["rolAdmin"]){
				return true;
			}else{
				return false;
			}
		}
	}
  }
