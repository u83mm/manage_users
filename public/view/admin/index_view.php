<?php	
	use model\classes\PageClass;

	$page = new PageClass();

	$page->do_html_header($page->title, $page->h1, $page->meta_name_description, $page->meta_name_keywords);
	$page->do_html_nav($page->menus);
?>
	<h4>Vista de Administración</h4>
    <div class="col mx-auto">
        <?php echo $message = $error_msg ?? $success_msg ?? ""; ?>
        <div class="row">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>User Name</th>
                        <th>Password</th>
                        <th>Email</th>
                        <th>Role</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($rows as $value) { ?>
                    <tr>
                        <td><?php echo $value['id_user']; ?></td>
                        <td><?php echo $value['user_name']; ?></td>
                        <td><?php echo $value['password']; ?></td>
                        <td><?php echo $value['email']; ?></td>
                        <td><?php echo $value['role']; ?></td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
        <div class="row">
            <form action="#" method="post"><input type="submit" class="btn btn-primary mb-5" name="action" value="New"></form>
        </div>
        
    </div>    
<?php
	$page->do_html_footer();
?>