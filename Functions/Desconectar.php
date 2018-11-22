<?php
/*
	Destruir la sesión del usuario
*/
session_start();
session_destroy();
session_start();
$_SESSION['rolAdmin'] = false;
header('Location: ../index.php');//Esto te manda al index

?>
