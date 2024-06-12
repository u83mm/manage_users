<form class="d-inline" action="/admin/delete" method="post" onsubmit="return confirm('¿Estás seguro de querer eliminar el registro?')">
    <input type="hidden" name="id_user" value="<?php echo $value['id']; ?>">
    <input type="submit" class="btn btn-outline-danger" name="action" value="Delete">
</form>