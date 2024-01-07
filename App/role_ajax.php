<?php

namespace app;

use app\Models\UserModel;

$userModel = UserModel::getUserModel();

if(isset($_POST["userId"])) {
    $userData = $userModel->getUserData($_POST["userId"]);
?>
<div id="edit-user-modal" class="edit-user-modal d-flex justify-content-center align-items-center pe-2 ps-2">
    <div class="edit-user-content signup-wrap rounded-4 box-shadow col-12 col-sm-8 col-md-7 col-lg-5">
        <button class="role-close-button" onclick="this.parentElement.parentElement.remove()">&#10005;</button>
        <div class="d-flex justify-content-center">
            <div class="signup-wrap box-shadow rounded-4 feed p-1 mt-0">
                <p class="h4 feed-text me-3 ms-3"><?php echo "@".$userData["username"]; ?></p>
            </div>
        </div>
        <div class="signup-wrap box-shadow rounded-4 mt-3 ms-3 me-3 p-2">
            <img src="/Images/email_icon.png" width="30" height="30" alt="email icon">
            <?php echo $userData["email"]; ?>
        </div>
        <div class="signup-wrap box-shadow rounded-4 ms-3 feed col-8 col-sm-3 col-md-2 mb-3">
            <p class="h6 feed-text p-1">Roles</p>
        </div>
        <form action="/users/<?php echo $_POST["userId"] ?>" method="POST">
            <div class="container-fluid role-radio">
                <input type="radio" id="administrator" value="Administrator" name="role" />
                <label for="administrator" class="rounded-4 p-2">Administrator</label>
                <input type="radio" id="author" value="Author" name="role" />
                <label for="author" class="rounded-4 p-2">Author</label>
                <input type="radio" id="commenter" value="Commenter" name="role" />
                <label for="commenter" class="rounded-4 p-2">Commenter</label>
            </div>
            <button type="submit" class="role-save-button mt-3 rounded-4">Save</button>
        </form>
    </div>
</div>
<?php
}else{

}