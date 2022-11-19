<?php	
	use model\classes\PageClass;

	$page = new PageClass();

	$page->do_html_header($page->title, $page->h1, $page->meta_name_description, $page->meta_name_keywords);
	$page->do_html_nav($page->menus);
?>
	<h4>Vista de Registro</h4>
    <div class="col-6 mx-auto">
        <?php echo $message = $error_msg ?? $success_msg ?? ""; ?>
        <form action="#" method="post">
            <div class="row mb-3">
                <label class="col-sm-2 col-form-label" for="user_name">User:</label>
                <div class="col-sm-8">
                    <input class="form-control" type="text" name="user_name" id="user_name" required>
                </div>                
            </div>
            <div class="row mb-3">
                <label class="col-sm-2 col-form-label" for="password">Password:</label>
                <div class="col-sm-8">
                    <input class="form-control" type="password" name="password" id="password" required>
                </div>                
            </div>
            <div class="row mb-3">
                <label class="col-sm-2  col-form-label" for="email">Email:</label>
                <div class="col-sm-8">
                    <input class="form-control" type="email" name="email" id="email" required>
                </div>                
            </div>               
            <div class="row mb-3">
                <label class="col-sm-2" for="nome">&nbsp;</label>
                <div class="col-sm-8">
                    <input type="submit" value="Register">
                </div>                
            </div>                                                              
        </form>
    </div>    
<?php
	$page->do_html_footer();
?>