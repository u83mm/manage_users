<form action="#" method="post">
    <div class="row mb-3">
        <label class="col-sm-2 col-form-label" for="user_name">User:</label>
        <div class="col-sm-8">
            <input class="form-control" type="text" name="user_name" id="user_name" value="<?php if(isset($fields['user_name'])) echo $fields['user_name']; ?>" required>
        </div>                
    </div>
    <div class="row mb-3">
        <label class="col-sm-2 col-form-label" for="password">Password:</label>
        <div class="col-sm-8">
            <input class="form-control" type="password" name="password" id="password" value="<?php if(isset($fields['password'])) echo $fields['password']; ?>" required>
        </div>                
    </div>
    <div class="row mb-3">
        <label class="col-sm-2  col-form-label" for="email">Email:</label>
        <div class="col-sm-8">
            <input class="form-control" type="email" name="email" id="email" value="<?php if(isset($fields['email'])) echo $fields['email']; ?>" required>
        </div>                
    </div>               
    <div class="row mb-3">
        <label class="col-sm-2" for="nome">&nbsp;</label>
        <div class="col-sm-8">
            <input class="btn btn-primary" type="submit" name="action" value="New">
            <a class="btn btn-primary" href="/admin/index">Go back</a>
        </div>                
    </div>                                                              
</form>