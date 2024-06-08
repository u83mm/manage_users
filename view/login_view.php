<?php	
	use model\classes\PageClass;

	$page = new PageClass();

	$page->do_html_header($page->title, $page->h1, $page->meta_name_description, $page->meta_name_keywords);
	$page->do_html_nav($page->nav_links, "login");
?>	
    <div class="col-10 col-md-6 mx-auto credentials">
        <h4>Login</h4>
        <?php echo $message; ?>
        <form action="<?php PATH ?>" method="post">
            <div class="row mb-3">
                <label class="col-sm-2 col-md-3 col-form-label d-none" for="email">Email:</label>
                <div class="col-sm-8 mx-auto">
                    <input class="form-control" type="email" name="email" id="email" value="<?php if(isset($fields['email'])) echo $fields['email']; ?>" placeholder="Email" required>
                </div>                
            </div> 
            <div class="row mb-3">
                <label class="col-sm-2 col-md-3 col-form-label d-none" for="password">Password:</label>
                <div class="col-sm-8 mx-auto d-flex">
                    <div class="col-10 me-1">
                        <input class="form-control password" type="password" name="password" id="password" value="<?php if(isset($fields['password'])) echo $fields['password']; ?>" placeholder="Password" required>
                    </div>                    
                    <div class="col-1 col-md-1 d-flex justify-content-center align-items-center">
                        <img class="show_password p-0" src="/images/eye.svg" alt="eye" height="20">
                    </div>
                </div>                
            </div>                          
            <div class="row mb-3">                               
                <div class="col-sm-8 mx-auto">
                    <a class="col-12 d-inline-block mb-3" href="#">Forgot password?</a>
                    <input type="submit" value="Login">                    
                </div> 
                <div class="col-sm-8 mx-auto">
                    <p class="mt-3 d-inline-block">Don't have an account?</p> <a href="/register">Sign Up</a>
                </div>               
            </div>                                                              
        </form>
    </div>    
<?php
	$page->do_html_footer();
?>