<?php

global $templateData;
?>

<div class="d-flex justify-content-center m-3">
    <div class="col-12 col-md-6 col-lg-4 p-1">
        <div class="post box-shadow rounded-3 w-100">
            <div class="d-flex">
                <img alt="profile picture" src="<?php echo $templateData["post"]["author_profile_picture"]?>" width="45" height="45" class="rounded-5 ms-2 mt-2">
                <div>
                    <p class="h5 ptext"><?php use app\Models\UserModel;

                        echo $templateData["post"]["author_name"] ?></p>
                    <p class="h6 ptext post-username"><?php echo $templateData["post"]["author_username"] ?></p>
                </div>
            </div>
            <p class="ptext"><?php echo $templateData["post"]["content"] ?></p>
        </div>
    </div>
</div>
<br>
<div class="post-divider"></div>
<br>
<?php

if(isset($templateData["user_data"]) && $templateData["user_data"]["role"] >= UserModel::COMMENTER){
    ?>
    <div class="d-flex justify-content-center m-3 m-sm-0">
        <div class="signup-wrap box-shadow rounded-4 col-12 col-sm-8 col-md-6">
            <form method="post" action="/comments/<?php echo $templateData["post"]["id_article"]?>/" accept-charset="UTF-8">
                <div class="form-group p-3">
                    <label for="post-text-area"></label>
                    <textarea id="post-text-area" name="comment-content" placeholder="Type your comment" class="form-control create-post-textarea rounded-4" rows="2"></textarea>
                </div>
                <button type="submit" name="comment-post" value="comment" class="btn comment-button rounded-4 box-shadow">Comment</button>
            </form>
        </div>
    </div>
    <?php
}?>

<br>
<div class="d-flex justify-content-center m-3 m-sm-0">
    <div class="signup-wrap box-shadow rounded-4 col-12 col-sm-8 col-md-6 p-3">

        <?php
        if(count($templateData["comments"]) > 0){
        foreach($templateData["comments"] as $comment){
        ?>
        <div class="create-post-textarea p-2 rounded-4 mb-1">
            <?php if(isset($templateData["user_data"]) && $templateData["user_data"]["role"] >= UserModel::ADMIN){?>
            <div class="d-flex justify-content-end delete-comment">
                <form action="/comments/<?php echo $templateData["post"]["id_article"]?>/" method="POST">
                    <input type="number" name="id" value="<?php echo $comment["id_comment"] ?>" hidden="hidden">
                    <button type="submit" class="delete-post-button" name="delete-comment" aria-label="Close" >
                        <img src="/Images/trashcan-icon.png" width="25" height="25" alt="delete post">
                    </button>
                </form>
            </div>
            <?php } ?>
            <div class="d-flex mb-2">
                <img width="45" height="45" alt="profile picture" class="rounded-5 me-1" src="<?php echo str_replace(SITE_ROOT,"",$comment["author_profile_picture"]) ?>">
                <p class="h5 ptext mb-0"><?php echo $comment["author_name"] ?></p>
                <p class="h6 ptext comment-username"><?php echo $comment["author_username"] ?></p>
            </div>
            <p class="delpmargin comment-text"><?php echo $comment["content"] ?></p>
        </div>
        <?php }}else { ?>
        <p class="h4">No comments</p>
        <?php } ?>
    </div>
</div>