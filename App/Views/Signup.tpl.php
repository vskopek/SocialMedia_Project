<?php
global $templateData;

if(!$templateData["userLogged"]){
?>
<p class="signup-header h1">Create your account by filling out this form</p>

<div class="signup-wrap box-shadow rounded-4 p-3 m-3">
    <form action="/signup" method="POST">
        <div class="row">
            <label>Name</label>
            <div class="col">
                <label>
                    <input type="text" name="firstname" class="form-control" placeholder="First name">
                </label>
            </div>
            <div class="col-12 col-sm-12 col-lg-6 col-md-6">
                <label>
                    <input type="text" name ="lastname" class="form-control" placeholder="Last name">
                </label>
            </div>
        </div>
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" name="username" class="form-control" id="username" placeholder="Username">
        </div>
        <div class="form-group">
            <label for="email">Email address</label>
            <input type="email" name ="email" class="form-control" id="email" aria-describedby="emailHelp" placeholder="Enter email">
            <label for="password">Password</label>
            <input type="password" name="password" class="form-control" id="password" placeholder="Password">
        </div>
        <br>
        <button type="submit" name="register" class="btn btn-primary" value="register">Signup</button>
    </form>
</div>

<?php }else{?>
    <p class="signup-header h1">Already logged in, please log out before registering.</p>
    <form action="/signup" method="POST">
        <button type="submit" name="logout" class="btn btn-primary signup-logout" value="logout">Logout</button>
    </form>
<?php }?>