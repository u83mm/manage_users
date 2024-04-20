<?php	
	use model\classes\PageClass;

	$home = new PageClass();			

	$home->do_html_header($home->title, $home->h1, $home->meta_name_description, $home->meta_name_keywords);
	$home->do_html_nav($home->nav_links, "administration");
?>	
    <div class="col-6 mx-auto credentials">
		<h4>NEW USER</h4>
        <?php echo $message ?? ""; ?>
        <?php include(SITE_ROOT. "/../view/admin/form_view.php"); ?>
    </div>
<?php
	$home->do_html_footer();
?>