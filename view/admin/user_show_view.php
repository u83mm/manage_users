<?php	
	use model\classes\PageClass;

	$page = new PageClass();

	$page->do_html_header($page->title, $page->h1, $page->meta_name_description, $page->meta_name_keywords);
	$page->do_html_nav($page->nav_links);
?>	
    <div class="col-11 col-sm-8 col-lg-6 mx-auto credentials">
        <h4>SHOW USER</h4>
        <?php echo $message ?? ""; ?>
        <form id="admin_form" action="/admin/update" method="post">
            <input type="hidden" name="id_user" value="<?php echo $user['id_user']?>">
            <div class="row mb-3">
                <label class="col-12 col-sm-3 col-form-label text-sm-end" for="user_name">User:</label>
                <div class="col-sm-8">
                    <input class="form-control" type="text" name="user_name" id="user_name" value="<?php if(isset($user['user_name'])) echo $user['user_name']; ?>" required>
                </div>                
            </div>
            <div class="row mb-3">
                <label class="col-12 col-sm-3 col-form-label text-sm-end" for="password">Password:</label>
                <div class="col-10 col-sm-8">
                    <input class="form-control" type="password" name="password" id="password" value="<?php if(isset($user['password'])) echo $user['password']; ?>" readonly>
                </div>
                <div class="col-1 col-md-1 d-flex justify-content-center align-items-center">
                    <img class="show_password p-0" src="/images/eye.svg" alt="eye" height="20">
                </div>              
            </div>
            <div class="row mb-3">
                <label class="col-12 col-sm-3 col-form-label text-sm-end" for="email">Email:</label>
                <div class="col-sm-8">
                    <input class="form-control" type="email" name="email" id="email" value="<?php if(isset($user['email'])) echo $user['email']; ?>" required>
                </div>                
            </div>               
            <div class="row mb-3">                
                <div class="col-sm-8 mx-auto">
                    <input class="mb-2" type="submit" name="action" value="Update">
                    <input id="change_passwd" type="submit" value="Change Password">
                </div>                
            </div>                                                              
        </form>
    </div>    
<?php
	$page->do_html_footer();
?>