<?php	
	use model\classes\PageClass;

	$home = new PageClass();			

	$home->do_html_header($home->title, $home->h1, $home->meta_name_description, $home->meta_name_keywords);
	$home->do_html_nav($home->nav_links);
?>	
    <div class="col-12 col-md-8 col-xl-6 mx-auto credentials">
        <h4>CHANGE PASSWORD</h4>
        <?php echo $message ?? ""; ?>
        <form action="<?php PATH ?>" method="post"> 
            <input type="hidden" name="id_user" value="<?php if(isset($fields['id_user'])) echo $fields['id_user']; ?>">           
            <div class="row mb-3">
                <label class="col-sm-4 col-form-label" for="password">Password:</label>
                <div class="col-10 col-sm-6">
                    <input class="form-control" type="password" name="password" id="password" value="<?php if(isset($fields['password'])) echo $fields['password']; ?>" required>
                </div>
                <div class="col-1 d-flex justify-content-center align-items-center ps-0">
                    <img class="show_password p-0" src="/images/eye.svg" alt="eye" height="20">
                </div>                
            </div>
            <div class="row mb-3">
                <label class="col-sm-4 col-form-label" for="new_password">Repeat Password:</label>
                <div class="col-10 col-sm-6">
                    <input class="form-control" type="password" name="new_password" id="new_password" value="<?php if(isset($fields['new_password'])) echo $fields['new_password']; ?>" required>
                </div>
                <div class="col-1 d-flex justify-content-center align-items-center ps-0">
                    <img class="show_password p-0" src="/images/eye.svg" alt="eye" height="20">
                </div>                
            </div>               
            <div class="row mb-3">
                <label class="col-sm-4" for="nome">&nbsp;</label>
                <div class="col-sm-6">
                    <input type="submit" name="action" value="Change Password">
                    <a class="btn btn-primary mt-3" href="/admin/show/<?php if(isset($fields['id_user'])) echo $fields['id_user']; ?>">Go back</a>
                </div>                
            </div>                                                              
        </form>
    </div>    
<?php
	$home->do_html_footer();
?>