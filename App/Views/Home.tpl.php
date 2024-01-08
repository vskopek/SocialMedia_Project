<?php
global $templateData;

use app\Models\UserModel;

if($templateData["wrongCredentials"]){
?>
<div class="alert alert-danger" role="alert">
    Wrong username or password!
</div>
<?php
}
if($templateData["loggedIn"]){
    ?>
    <div class="alert alert-success" role="alert">
        Successful login!
    </div>
<?php }?>


<?php
if(isset($templateData["user_data"]) && $templateData["user_data"]["role"] >= UserModel::AUTHOR){
    ?>
<div class="d-flex justify-content-center m-3 m-sm-0">
    <div class="signup-wrap box-shadow rounded-4 col-12 col-sm-8 col-md-6">
        <p class="h3 feed-text">Create post</p>
        <div class="post-divider"></div>
        <form method="post" action="/" accept-charset="UTF-8">
            <div class="form-group p-3">
                <label for="post-text-area"></label>
                <textarea id="post-text-area" name="postcontent" placeholder="..." class="form-control create-post-textarea rounded-4" rows="5"></textarea>
            </div>
            <button type="submit" name="createpost" value="Post" class="btn post-button rounded-4 box-shadow">Post</button>
        </form>
    </div>
</div>
<?php
}?>
<br><br>
<div class="d-flex justify-content-center">
    <div class="signup-wrap box-shadow rounded-4 feed col-8 col-sm-3 col-md-2 p-1">
        <p class="h3 feed-text">Feed</p>
    </div>
</div>
<br>

<button type="button" class="delete-post-button" aria-label="Close">
    <img src="/Images/trashcan-icon.png" width="25" height="25" alt="delete post"></img>
</button>

<div class="container-fluid">
    <?php

    $c = 1;
    $currentEcho = '<div class="row px-2">';
    foreach($templateData["posts"] as $post){
        $currentEcho .=
        '<div class="col-12 col-md-6 col-lg-3 p-1">
            <div class="post box-shadow rounded-3 w-100">
                <div class="d-flex">
                    <img src="'.$post["author_profile_picture"].'" width="45" height="45" class="rounded-5 ms-2 mt-2">
                    <div>
                        <p class="h5 ptext">
                        '.$post["author_name"].'
                        </p>
                        <p class="h6 ptext post-username">'.$post["author_username"].'</p>
                    </div>
                </div>
                <p class="ptext">'.$post["content"].'</p>
                <div class="bottom">
                    <a class="comments-link" href="/comments/'.$post["id_article"].'">Comments</a>
                </div>
            </div>
        </div>';
        $c++;
        if($c >= 5){
            $c = 1;
            echo $currentEcho.'</div>';
            $currentEcho = '<div class="row px-2">';
        }
    }
    if(strcmp($currentEcho,'<div class="row px-2">') != 0){
        echo $currentEcho.'</div>';
    }
    ?>
</div>