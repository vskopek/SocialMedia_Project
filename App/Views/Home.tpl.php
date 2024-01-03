<?php
global $templateData;

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

<div class="container-fluid">
    <div class="row px-2">
        <div class="col-12 col-md-6 col-lg-3 p-1">
            <div class="post rounded-3">
                <p class="h5 ptext">Václav Škopek</p>
                <p class="ptext">Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Integer in sapien. Class aptent taciti sociosqu ad litora torquent</p>
                <div class="bottom">
                    <a class="comments-link" href="/comments">Comments</a>
                </div>
            </div>
        </div>

    </div>
</div>