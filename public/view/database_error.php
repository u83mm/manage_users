<?php
	model\classes\Loader::init(__DIR__ . "/..");

	$page_error = new model\classes\PageClass;	
	$page_error->title = "Error | Site_name";	
						
	$page_error->do_html_header($page_error->title, $page_error->h1, $page_error->meta_name_description, $page_error->meta_name_keywords);
	$page_error->do_html_nav($page_error->menus);		
		echo $message = $error_msg ?? $success_msg;
	$page_error->do_html_footer();
?>
