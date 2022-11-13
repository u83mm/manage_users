<?php
	declare(strict_types=1);
	
	namespace model\classes;

	class PageClass {
		public $title = "Aquí va el title";
		public $h1 = "Desarrollo de nuestra aplicación";
		public $meta_name_description = "Aquí va una descripción del sitio";
		public $meta_name_keywords = "Aquí van palabras clave para los buscadores";
		public $menus = array (
			"Home |"			=>	"/",
			"Registration |"	=> 	"/Controller/registerController.php",
			"Administration |"	=>	"/Controller/adminController.php",
			"Login |"			=> 	"/Controller/loginController.php",			
		);

		public function __construct()
		{
			if (isset($_SESSION['id_user'])) {
				array_pop($this->menus);
				$this->menus["Logout"] = "/Controller/loginController.php?action=logout"; 
			}
		}

		public function do_html_header(string $title, string $h1, string $meta_name_description, string $meta_name_keywords) {
?>
		<!DOCTYPE html>
		<html lang="es">
			<head>
				<meta charset='UTF-8' />
				<meta name="title" content="Web site" /> 
				<meta name="description" content="<?php echo $this->meta_name_description; ?>" />
				<meta name="keywords" content="<?php echo $this->meta_name_keywords; ?>" />
				<meta name="robots" content="All" />  
				<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
				<title><?php echo $this->title; ?></title>
				<!-- <link rel="shorcut icon" href="imagen para el favicon"> -->
				<link rel="icon" type="image/gif" href="/images/favicon.ico">
				<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
				<link rel="stylesheet" type="text/css" href="/css/jquery-ui.min.css">
				<link rel="stylesheet" type="text/css" href="/css/reset.css">
				<link rel="stylesheet" type="text/css" href="/css/estilo.css">
				<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
				<script type="text/javascript" src="/js/jquery.js"></script>
				<script type="text/javascript" src="/js/jquery-ui.min.js"></script>
				<script type="text/javascript" src="/js/jquery.validate.min.js"></script>
				<script type="text/javascript" src="/js/eventos.js"></script>
			</head>
			<body>
			<main>
				<header>
					<h1><?php echo $this->h1; ?></h1><hr />
				</header>
<?php			
		}

		public function do_html_nav($menus=NULL) {
?>
			<nav>
				<ul>
<?php
			foreach($this->menus as $name => $url) {
				if((!isset($_SESSION['role']) && $name === "Administration |") || (isset($_SESSION['role']) && $_SESSION['role'] !== "ROLE_ADMIN" && $name === "Administration |")) continue;
?>
					<li><a href="<?php echo $url; ?>"><?php echo $name; ?></a></li>
<?php
			}
?>
				</ul>
			</nav>
			<noscript><h4>Tienes javaScript desactivado</h4></noscript>
<?php
		}

		public function do_html_footer() {
?>
			</main>
				<footer>
					<p>Copyright &copy; reserved <?php echo date("Y"); ?></p>
				</footer>
			</body>
		</html>
<?php		
		}
	}
?>
