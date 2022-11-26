<form class="d-inline" action="#" method="post" onsubmit="return confirm('¿Estás seguro de querer eliminar el registro?')">
    <input type="hidden" name="id_user" value="<?php echo $value['id_user']; ?>">
    <input type="submit" class="btn btn-outline-danger" name="action" value="Delete">
</form>