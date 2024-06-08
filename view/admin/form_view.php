<form action="#" method="post">
    <div class="row mb-3">
        <label class="col-12 col-sm-3 col-form-label text-md-end" for="user_name">User:</label>
        <div class="col-sm-8">
            <input class="form-control" type="text" name="user_name" id="user_name" value="<?php if(isset($fields['user_name'])) echo $fields['user_name']; ?>" required>
        </div>                
    </div>
    <div class="row mb-3">
        <label class="col-12 col-sm-3 col-form-label text-md-end" for="password">Password:</label>
        <div class="col-10 col-sm-8">
            <input class="form-control" type="password" name="password" id="password" value="<?php if(isset($fields['password'])) echo $fields['password']; ?>" required>
        </div>
        <div class="col-1 d-flex justify-content-center align-items-center ps-0">
            <img class="show_password p-0" src="/images/eye.svg" alt="eye" height="20">
        </div>                
    </div>
    <div class="row mb-3 mb-5 mb-md-4">
        <label class="col-12 col-sm-3 col-form-label text-md-end" for="email">Email:</label>
        <div class="col-sm-8">
            <input class="form-control" type="email" name="email" id="email" value="<?php if(isset($fields['email'])) echo $fields['email']; ?>" required>
        </div>                
    </div>               
    <div class="row mb-3">        
        <div class="col-sm-8 mx-auto">
            <input type="submit" name="action" value="New">
            <a class="btn btn-primary mt-3" href="/admin/index">Go back</a>
        </div>                
    </div>                                                              
</form>