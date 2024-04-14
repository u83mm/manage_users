<?php	
	use model\classes\PageClass;

	$home = new PageClass();			

	$home->do_html_header($home->title, $home->h1, $home->meta_name_description, $home->meta_name_keywords);
	$home->do_html_nav($home->nav_links, "home");
?>
	<section class="row mt-5">
		<div class="col-6 center">
			<img src="/images/user_admin.png" alt="user image">
		</div>
		<div class="col-6 center">
			<h2>Welcome to Manage Users Application</h2>
			<p>Add users with different roles to your system</p>
		</div>
	</section>		
<?php
	$home->do_html_footer();
?>
