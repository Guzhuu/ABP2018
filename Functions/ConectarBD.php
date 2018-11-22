<?php
// funcion ConectarBD()
// funcion de conexión única para toda la aplicación a la bd
// Es el único lugar donde se definen los parametros de conexión a la bd
function ConectarBD() //declaración de funcion
	{
		// se ejecuta la función de conexión mysqli y se recoge el manejador
	    $mysqli = new mysqli("localhost", "AWGPusr", "AWGPass", "awgp"); //maquina, user, pass, bd
		// si hay error en la conexión se muestra el mensaje de error
		if ($mysqli->connect_errno) {
			echo "Fallo al conectar a MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
		}
		// la función devuelve el manejador
		return $mysqli;
	}
?>