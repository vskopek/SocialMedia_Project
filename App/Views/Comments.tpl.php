<?php

global $templateData;
?>

<div class="d-flex justify-content-center m-3">
    <div class="col-12 col-md-6 col-lg-4 p-1">
        <div class="post box-shadow rounded-3 w-100">
            <p class="h5 ptext"><?php use app\Models\UserModel;

                echo $templateData["post"]["author_name"] ?></p>
            <p class="h6 ptext post-username"><?php echo $templateData["post"]["author_username"] ?></p>
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
            <div class="d-flex">
                <p class="h5 ptext"><?php echo $comment["author_name"] ?></p>
                <p class="h6 ptext comment-username"><?php echo $comment["author_username"] ?></p>
            </div>
            <p class="delpmargin"><?php echo $comment["content"] ?></p>
        </div>
        <?php }}else { ?>
        <p class="h4">No comments</p>
        <?php } ?>
    </div>
</div>