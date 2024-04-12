<?php	
	use model\classes\PageClass;

	$page = new PageClass();

	$page->do_html_header($page->title, $page->h1, $page->meta_name_description, $page->meta_name_keywords);
	$page->do_html_nav($page->nav_links, "registration");
?>	
    <div class="col-6 mx-auto credentials">
        <h4>Signup</h4>
        <?php echo $message = $error_msg ?? $success_msg ?? ""; ?>
        <form action="#" method="post">
            <div class="row mb-3">
                <label class="col-sm-2 col-form-label d-none" for="user_name">User:</label>
                <div class="col-sm-8 mx-auto">
                    <input class="form-control" type="text" name="user_name" id="user_name" value="<?php if(isset($fields['user_name'])) echo $fields['user_name']; ?>" placeholder="User" required>
                </div>                
            </div>
            <div class="row mb-3">
                <label class="col-sm-2 col-form-label d-none" for="password">Password:</label>
                <div class="col-sm-8 mx-auto">
                    <input class="form-control" type="password" name="password" id="password" value="<?php if(isset($fields['password'])) echo $fields['password']; ?>" placeholder="Password" required>
                </div>                
            </div>
            <div class="row mb-3">
                <label class="col-sm-2  col-form-label d-none" for="email">Email:</label>
                <div class="col-sm-8 mx-auto">
                    <input class="form-control" type="email" name="email" id="email" value="<?php if(isset($fields['email'])) echo $fields['email']; ?>" placeholder="Email" required>
                </div>                
            </div>               
            <div class="row mb-3">                
                <div class="col-sm-8 mx-auto">
                    <input type="submit" value="Register">
                </div> 
                <div class="col-sm-8 mx-auto">
                    <p class="mt-3 d-inline-block">Already have an account?</p> <a href="/login">Login</a>
                </div>                
            </div>                                                              
        </form>
    </div>    
<?php
	$page->do_html_footer();
?>