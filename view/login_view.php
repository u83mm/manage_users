<?php	
	use model\classes\PageClass;

	$page = new PageClass();

	$page->do_html_header($page->title, $page->h1, $page->meta_name_description, $page->meta_name_keywords);
	$page->do_html_nav($page->nav_links, "login");
?>	
    <div class="col-10 col-md-6 mx-auto mt-5 credentials">
        <h4>Login</h4>
        <?php echo $message = $error_msg ?? $success_msg ?? ""; ?>
        <form action="#" method="post">
            <div class="row mb-3">
                <label class="col-sm-2 col-md-3 col-form-label d-none" for="email">Email:</label>
                <div class="col-sm-8 mx-auto">
                    <input class="form-control" type="email" name="email" id="email" value="<?php if(isset($fields['email'])) echo $fields['email']; ?>" placeholder="Email" required>
                </div>                
            </div> 
            <div class="row mb-3">
                <label class="col-sm-2 col-md-3 col-form-label d-none" for="password">Password:</label>
                <div class="col-sm-8 mx-auto">
                    <input class="form-control" type="password" name="password" id="password" value="<?php if(isset($fields['password'])) echo $fields['password']; ?>" placeholder="Password" required>
                </div>                
            </div>                          
            <div class="row mb-3">
                <!-- <label class="col-sm-2 col-md-3" for="none">&nbsp;</label> -->                
                <div class="col-sm-8 mx-auto">
                    <a class="col-12 d-inline-block mb-3" href="#">Forgot password?</a>
                    <input type="submit" value="Login">                    
                </div> 
                <div class="col-sm-8 mx-auto">
                    <p class="mt-3 d-inline-block">Don't have an account?</p> <a href="#">Signup</a>
                </div>               
            </div>                                                              
        </form>
    </div>    
<?php
	$page->do_html_footer();
?>