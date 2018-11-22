<?php

class Deportista_juega_Partido
{
  public $DNI_Deportista1;
  public $DNI_Deportista2;
  public $DNI_Deportista3;
  public $DNI_Deportista4;
  public $Partido_Partido;
	function __construct($DNI_Deportista1,$DNI_Deportista2, $DNI_Deportista3, $DNI_Deportista4,$Partido_Partido)
  {
  		$this ->DNI_Deportista1= $DNI_Deportista1;
      $this ->DNI_Deportista1= $DNI_Deportista1;
      $this ->DNI_Deportista1= $DNI_Deportista1;
      $this ->DNI_Deportista1= $DNI_Deportista1;
      $this ->Partido_Partido= $Partido_Partido;
		
	}

  public function getDNI_Deportista1() {
    return $this ->DNI_Deportista1;
  }

  public function getDNI_Deportista2() {
    return $this ->DNI_Deportista2;
  }

  public function getDNI_Deportista3() {
    return $this ->DNI_Deportista3;
  }

  public function getDNI_Deportista4() {
    return $this ->DNI_Deportista4;
  }
 
  public function getPartido_Partido() {
    return $this ->Partido_Partido;
  }

  public function setDNI_Deportista1($DNI_Deportista1){
    $this->DNI_Deportista1 = $DNI_Deportista1;
  }

  public function setDNI_Deportista2($DNI_Deportista2){
    $this->DNI_Deportista2 = $DNI_Deportista2;
  }

  public function setDNI_Deportista3($DNI_Deportista3){
    $this->DNI_Deportista3 = $DNI_Deportista3;
  }

  public function setDNI_Deportista4($DNI_Deportista4){
    $this->DNI_Deportista4 = $DNI_Deportista4;
  }

  public function setCodigoHorario ($codigoHorario){
    $this ->DNI_Deportista2 = $DNI_Deportista2;
  }

  public function setPartido_Partido($Partido_Partido){
    $this->Partido_Partido = $Partido_Partido;
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

}

?>