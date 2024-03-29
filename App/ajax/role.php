<?php

namespace app\ajax;

use app\Models\UserModel;

$userModel = UserModel::getUserModel();
$loggedUserData = $userModel->getCurrentUserData();
if(isset($_POST["userId"]) && $loggedUserData != null && $loggedUserData["role"] >= UserModel::ADMIN) {
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
                <?php
                    if($loggedUserData["role"] >= UserModel::SUPER_ADMIN){
                ?>
                <input type="radio" id="administrator" value="Administrator" name="role" <?php if($userData["role"] == UserModel::ADMIN){ ?> checked="checked" <?php }?> />
                <label for="administrator" class="rounded-4 p-2">Administrator</label>
                <?php }?>
                <input type="radio" id="author" value="Author" name="role" <?php if($userData["role"] == UserModel::AUTHOR){ ?> checked="checked" <?php }?> />
                <label for="author" class="rounded-4 p-2">Author</label>
                <input type="radio" id="commenter" value="Commenter" name="role" <?php if($userData["role"] == UserModel::COMMENTER){ ?> checked="checked" <?php }?> />
                <label for="commenter" class="rounded-4 p-2">Commenter</label>
            </div>
            <button type="submit" class="role-save-button mt-3 rounded-4" name="edit-role" value="ok">Save</button>
            <button type="submit" class="delete-user-button mt-3 rounded-4" name="delete-user" value="ok">Delete user</button>
        </form>
    </div>
</div>
<?php
}