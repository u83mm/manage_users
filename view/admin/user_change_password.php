<?php	
	use model\classes\PageClass;

	$home = new PageClass();			

	$home->do_html_header($home->title, $home->h1, $home->meta_name_description, $home->meta_name_keywords);
	$home->do_html_nav($home->menus);
?>
	<h4>CHANGE PASSWORD</h4>
    <div class="col-6 mx-auto">
        <?php echo $message = $error_msg ?? $success_msg ?? ""; ?>
        <form action="#" method="post"> 
            <input type="hidden" name="id_user" value="<?php echo $id_user; ?>">           
            <div class="row mb-3">
                <label class="col-sm-4 col-form-label" for="password">Password:</label>
                <div class="col-sm-6">
                    <input class="form-control" type="password" name="password" id="password" required>
                </div>                
            </div>
            <div class="row mb-3">
                <label class="col-sm-4 col-form-label" for="new_password">Repeat Password:</label>
                <div class="col-sm-6">
                    <input class="form-control" type="password" name="new_password" id="new_password" required>
                </div>                
            </div>               
            <div class="row mb-3">
                <label class="col-sm-4" for="nome">&nbsp;</label>
                <div class="col-sm-6">
                    <input type="submit" name="action" value="Change Password">
                </div>                
            </div>                                                              
        </form>
    </div>    
<?php
	$home->do_html_footer();
?>