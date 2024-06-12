<?php	
	use model\classes\PageClass;

	$page = new PageClass();

	$page->do_html_header($page->title, $page->h1, $page->meta_name_description, $page->meta_name_keywords);
	$page->do_html_nav($page->nav_links, "administration");
?>
	<h4>Admin view</h4>
    <div class="col mx-auto mb-3">
        <?php echo $message ?? ""; ?>
        <div class="row table-responsive">
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr class="text-center">
                            <th>Id</th>
                            <th>User Name</th>                        
                            <th>Email</th>
                            <th>Role</th>
                            <th>Options</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($rows as $value) { ?>
                        <tr>
                            <td><?php echo $value['id']; ?></td>
                            <td><?php echo $value['user_name']; ?></td>                        
                            <td><?php echo $value['email']; ?></td>
                            <td><?php echo $value['role']; ?></td>
                            <td class="text-center">
                                <form action="/admin/show" method="post" class="d-inline">
                                    <input type="hidden" name="id_user" value="<?php echo $value['id']; ?>">
                                    <input class="btn btn-outline-success" type="submit" name="action" value="Show">
                                </form>
                                <?php include(SITE_ROOT . "/../view/admin/user_delete_form.php"); ?>
                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>            
        </div>
        <div class="row">
            <div class="col-12">
                <a class="btn btn-primary" href="/admin/new">New</a>
            </div>                   
        </div>        
    </div>    
<?php
	$page->do_html_footer();
?>