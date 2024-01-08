<?php
global $templateData;

use app\Models\UserModel;

if(!isset($templateData["user_data"])){
?>


<p class="signup-header h1">Please log in to view your profile</p>
<br>
<div class="signup-wrap box-shadow rounded-4 p-3 m-3">
    <form class="form-horizontal" method="post" action="/" accept-charset="UTF-8">
        <label for="username"></label>
        <input id="username" class="form-control login" type="text" name="username" placeholder="Username">
        <label for="password"></label>
        <input id="password" class="form-control login" type="password" name="password" placeholder="Password">
        <br>
        <input class="btn btn-primary" type="submit" name="login" value="Login">
    </form>
    <div class="dropdown-divider"></div>
</div>
<a class="navbar-signup m-4" href="/signup">Don't have an account?</a>
<?php
}else{
?>
<div class="signup-wrap rounded-4 m-4 box-shadow p-3">
    <img width="300" height="300" alt="profile picture" class="rounded-5 m-0" src="<?php echo str_replace(SITE_ROOT,"",$templateData["user_data"]["profile_picture"]) ?>">
    <p class="h1 ms-1 mt-1 mb-0"><?php echo sprintf("%s %s", $templateData["user_data"]["firstname"],$templateData["user_data"]["lastname"]); ?></p>
    <p class="m-0 ms-1 mt-0"><?php echo sprintf("@%s",$templateData["user_data"]["username"]); ?></p>
</div>
<div class="container-fluid">
    <div class="row px-2">
        <div class="user-credentials rounded-4 box-shadow m-4 p-3 col-lg-3">
            <div>
                <img src="/Images/email_icon.png" width="30" height="30" alt="email icon">
                <br>
                <?php echo $templateData["user_data"]["email"]; ?>
            </div>
            <br>
            <div>
                <img src="/Images/role_icon.png" width="30" height="30" alt="role icon">
                <br>
                <?php echo UserModel::STRING_ROLES[$templateData["user_data"]["role"]]; ?>
            </div>
        </div>
        <?php
        if($templateData["user_data"]["role"] > UserModel::COMMENTER){ ?>
        <div class="container-fluid col-xl-8  col-md-12">
            <div class="d-flex justify-content-center">
                <div class="signup-wrap box-shadow rounded-4 feed col-8 col-sm-3 col-md-2 p-1">
                    <p class="h3 feed-text">Posts</p>
                </div>
            </div>
            <br>
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
    </div>
</div>


    <?php
        }
}


