<?php
global $templateData;

if(!$templateData["userLogged"]){
?>
<p class="signup-header h1">Create your account by filling out this form</p>

<div class="signup-wrap box-shadow rounded-4 p-3 m-3">
    <form action="/signup" method="POST" enctype="multipart/form-data">
        <div class="row">
            <div class="col">
                <label for="firstname" class="mb-1">First name</label>
                <input type="text" id="firstname" name="firstname" class="form-control" placeholder="First name">
            </div>
            <div class="col-12 col-sm-12 col-lg-6 col-md-6">
                <label for="lastname" class="mb-1">Last name</label>
                <input type="text" id="lastname" name ="lastname" class="form-control" placeholder="Last name">
            </div>
        </div>
        <div class="form-group">
            <label for="username" class="mb-1">Username</label>
            <input type="text" name="username" class="form-control" id="username" placeholder="Username">
        </div>
        <div class="form-group">
            <label for="email" class="mb-1">Email address</label>
            <input type="email" name ="email" class="form-control" id="email" aria-describedby="emailHelp" placeholder="Enter email">
            <label for="password" class="mb-1">Password</label>
            <input type="password" name="password" class="form-control" id="password" placeholder="Password">
        </div>
        <div class="form-group mt-3">
            <label for="profile_picture" class="upload-profile-picture rounded-4 p-2">
                Upload profile picture
                <input type="file" name="profile_picture" id="profile_picture" accept="image/png, image/jpeg" onchange="previewProfile(this);">
            </label>
        </div>
        <img src="/Images/profile-picture-icon.png" class="rounded-5 mt-2 mb-2" alt="profile picture" id="profile-picture-preview" width="200" height="200">
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