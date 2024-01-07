<?php
global $templateData
?>

<?php

use app\Models\UserModel;

if(isset($templateData["user_data"]) && $templateData["user_data"]["role"] >= UserModel::ADMIN){
?>

<div id="insert-modal">
</div>



<div class="d-flex justify-content-center m-3 m-sm-0">
    <div class="signup-wrap box-shadow rounded-4 col-12 col-sm-8 col-md-6 p-3">

        <?php
        if(count($templateData["users"]) > 0){
        foreach($templateData["users"] as $user){
        ?>
        <div class="create-post-textarea p-2 rounded-4 mb-1 pb-0">
            <div class="d-flex justify-content-between">
                <div class="ms-1" id="user-content">
                    <p class="h5 ptext mb-0" id="name">
                        <?php echo sprintf("%s %s", $user["firstname"], $user["lastname"]); ?>
                    </p>
                    <p class="h6 ptext comment-username mt-0 ms-0" id="username">
                        <?php echo "@".$user["username"] ?>
                    </p>
                </div>
                <?php if($templateData["user_data"]["role"] > $user["role"]){ ?>
                <button class="mb-2 me-2 edit-user-button btn rounded-4" id="<?php echo $user["id_user"] ?>" onclick="editClicked(this.id)">Edit</button>
                <?php } ?>
            </div>
        </div>
        <?php }}else { ?>
        <p class="h4">No users</p>
        <?php } ?>
    </div>
</div>

<?php
} else { ?>

<p class="h1 error404">You have no rights to view this page!</p>

<?php
}