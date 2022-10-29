<?php
	function do_html_header($title, $h1, $root=NULL) { // Print header
?>
		<!DOCTYPE html>
		<html lang="es">
			<head>
				<meta charset='UTF-8' />
				<meta name="title" content="Web site" /> 
				<meta name="description" content="Aquí_va_una_breve_descripción_de_nuestro_sitio_para_los_buscadores" />
				<meta name="keywords" content="Aquí_van_palabras_clave_para_los_buscadores" />
				<meta name="robots" content="All" />  
				<meta name="viewport" content="width=device-width, initial-scale=1" />
				<title><?php echo $title; ?></title>
				<!-- <link rel="shorcut icon" href="imagen para el favicon"> -->
				<link rel="icon" type="image/gif" href="images/animated_favicon1.gif">
				<link rel="stylesheet" type="text/css" href="<?php echo $root; ?>/css/jquery-ui.min.css">
				<link rel="stylesheet" type="text/css" href="<?php echo $root; ?>/css/reset.css">
				<link rel="stylesheet" type="text/css" href="<?php echo $root; ?>/css/estilo.css">
				<script type="text/javascript" src="<?php echo $root; ?>/js/jquery.js"></script>
				<script type="text/javascript" src="<?php echo $root; ?>/js/jquery-ui.min.js"></script>
				<script type="text/javascript" src="<?php echo $root; ?>/js/jquery.validate.min.js"></script>
				<script type="text/javascript" src="<?php echo $root; ?>/js/eventos.js"></script>
			</head>
			<body>
			<main>
				<header>
					<h1><?php echo $h1; ?></h1><hr />
				</header>
<?php
	}

function do_html_heading($title) {
?>
	<h3><?php echo $title; ?></h3><br />
<?php
	}

	function do_html_nav($root=NULL) { // Print nav menu
?>
		<nav>
			<ul>
				<li><a href="<?php echo $root; ?>/index.php?action=home">Home</a></li>
<?php
				if(isset($_SESSION['valid_user'])) {
?>
					<li><a href="#">Link1</a></li>
					<li><a href="#">Link2</a></li>
					<li><a href="#">Link3</a></li>
					<li><a href="#">Link4</a></li>
<?php
				}
?>
			</ul>
		</nav>
<?php
	}

function do_html_section($title) { // Print Section
?>
		<section>
<?php
			if($title) {
				do_html_heading($title);
			}
?>			
		</section>	
<?php
	}

function do_html_footer() { // Print footer
?>			
			</main>
			<footer>
				<p>Copyright &copy; reserved <?php echo date("Y"); ?></p>
			</footer>
		</body>
	</html>	
<?php
	}
?>
