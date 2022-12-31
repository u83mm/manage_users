<?php	
	use model\classes\PageClass;

	$home = new PageClass();			

	$home->do_html_header($home->title, $home->h1, $home->meta_name_description, $home->meta_name_keywords);
	$home->do_html_nav($home->menus);
?>
	<h4>NEW USER</h4>
    <div class="col-6 mx-auto">
        <?php echo $message = $error_msg ?? $success_msg ?? ""; ?>
        <?php include(SITE_ROOT. "/../view/admin/form_view.php"); ?>
    </div>
<?php
	$home->do_html_footer();
?>