<?php
/* 
	Header genérico
	SELECT * FROM campeonato_consta_de_categorias WHERE campeonato_consta_de_categorias.Campeonato_Campeonato = 1 AND categoria.Categoria NOT IN (select campeonato_consta_de_categorias.Categoria_Categoria FROM campeonato_consta_de_categorias WHERE campeonato_consta_de_categorias.Campeonato_Campeonato = 1);
*/
	if (session_status() == PHP_SESSION_NONE) {//Sino existe la sesion, se comienza
		session_start();
	}
	?>
	<meta charset="utf-8"/>
	<title>AWGP</title>
	<link href="/css/style.css" type="text/css" rel="stylesheet"  media="(min-width:380px)">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
	<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
	<link rel="stylesheet" type="text/css" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">
	<html>
		<header>
			<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
				<a class="navbar-brand" href="#">AWGP</a>
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>

				<div class="collapse navbar-collapse" id="navbarColor01">
				  <ul class="navbar-nav mr-auto">
					<li class="nav-item active">
					  <a class="nav-link" href="../index.php">Inicio<span class="sr-only">(current)</span></a>
					</li>
	<?php
	if(isset($_SESSION['rolAdmin']) && $_SESSION['rolAdmin']){
		/************************************************************************HEADER ADMIN*******************************************************************************************/
		?>
			<li class="nav-item">
				<div class="dropdown nav-link">
				  <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="vertical-align: middle">
					Controllers
				  </button>
				  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
					<a class="dropdown-item" href="../Controllers/Controller_Campeonato.php">Campeonato</a>
					<a class="dropdown-item" href="../Controllers/Controller_Categoria.php">Categoria</a>
					<a class="dropdown-item" href="../Controllers/Controller_Clase.php">Clase</a>
					<a class="dropdown-item" href="../Controllers/Controller_Deportista.php">Deportista</a>
					<a class="dropdown-item" href="../Controllers/Controller_Enfrentamiento.php">Enfrentamiento</a>
					<a class="dropdown-item" href="../Controllers/Controller_Escuela.php">Escuela</a>
					<a class="dropdown-item" href="../Controllers/Controller_Grupo.php">Grupo</a>
					<a class="dropdown-item" href="../Controllers/Controller_Horario.php">Horario</a>
					<a class="dropdown-item" href="../Controllers/Controller_Pareja.php">Pareja</a>
					<a class="dropdown-item" href="../Controllers/Controller_Partido.php">Partido</a>
					<a class="dropdown-item" href="../Controllers/Controller_Pista.php">Pista</a>
					<a class="dropdown-item" href="../Controllers/Controller_Reserva.php">Reserva</a>
				  </div>
				</div>
			</li>
			<li class="nav-item">
			  <a class="nav-link" href="../Functions/Desconectar.php">Desconectarse</a>
			</li>
		<?php
		/************************************************************************FIN ADMIN*******************************************************************************************/
	}else if(isset($_SESSION['DNI'])){
		/************************************************************************HEADER USUARIO*******************************************************************************************/
		?>
			<li class="nav-item">
			  <a class="nav-link text-nowrap" href="../Controllers/Controller_Reserva.php">Reservar pista</a>
			</li>
			<li class="nav-item">
			  <a class="nav-link text-nowrap" href="../Controllers/Controller_Reserva.php?submit=VERRESERVAS">Mis reservas</a>
			</li>
			<li class="nav-item">
			  <a class="nav-link text-nowrap" href="../Controllers/Controller_Pareja.php">Mis parejas</a>
			</li>
			<li class="nav-item">
			  <a class="nav-link text-nowrap" href="../Controllers/Controller_Deportista.php?submit=PERFIL">Mi perfil</a>
			</li>
			<li class="nav-item">
			  <a class="nav-link text-nowrap" href="../Controllers/Controller_Campeonato.php?submit=ESCOGERPAREJA">Inscribirse a un campeonato</a>
			</li>
			<li class="nav-item">
			  <a class="nav-link text-nowrap" href="../Controllers/Controller_Clase.php?submit=MISCLASES">Ver clases</a>
			</li>
			<li class="nav-item">
			  <a class="nav-link text-nowrap" href="../Controllers/Controller_Clase.php?submit=APUNTARSE">Apuntarse a clases</a>
			</li>
			<li class="nav-item">
			  <a class="nav-link text-nowrap" href="../Controllers/Controller_Campeonato.php?submit=SHOWALLFORUSER">Ver Campeonatos</a>
			</li>
			<?php
			if(isset($_SESSION['rolEntrenador']) && $_SESSION['rolEntrenador']){
				?>
				<li class="nav-item">
				  <a class="nav-link text-nowrap" href="../Controllers/Controller_Clase.php">Agenda de clases</a>
				</li>
				<?php
			}
			?>
			<li class="nav-item">
			  <a class="nav-link text-nowrap" href="../Functions/Desconectar.php">Desconectarse</a>
			</li>
		<?php
		/************************************************************************FIN USUARIO*******************************************************************************************/
	}else{
		/************************************************************************HEADER GUEST*******************************************************************************************/
		/*?>
			<li class="nav-item">
			  <a class="nav-link" href="../Controllers/Controller_Registro.php">Registrarse</a>
			</li>
		<?php*/
		/************************************************************************FIN GUEST*******************************************************************************************/
	}
?>
		  </ul>
		</div>
	</nav>
</header>
<body>
