<?php	
	use model\classes\PageClass;

	$home = new PageClass();	

	$home->do_html_header($home->title, $home->h1, $home->meta_name_description, $home->meta_name_keywords);
	$home->do_html_nav($home->menus);
?>
	<h4>Comenzar a poner contenido.</h4>
<?php
	$home->do_html_footer();
?>
