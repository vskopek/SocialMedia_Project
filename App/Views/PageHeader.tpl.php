<?php global $templateData?>

<!doctype html>
<html lang="cs">
<head>
    <meta charset='utf-8'>
    <meta name="viewport" content="width=device-width, initial-scale=1">

<!--    <script src="/node_modules/bootstrap/dist/js/bootstrap.min.js"></script>-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
    <script src="/js/role_ajax.js"></script>
    <script src="/js/profile-picture.js"></script>
    <link rel="stylesheet" type="text/css" href="/node_modules/bootstrap/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="/styles.css" />
    <link rel="icon" type="image/x-icon" href="/icon.ico">

    <title><?php use app\Models\UserModel;

        echo $templateData["title"]; ?></title>
</head>
<body>
<nav class="navbar navbar-light navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
        <a class="navbar-brand" href="/">
            <img src="/icon.ico" width="30" height="30" class="d-inline-block align-top" alt="">
            Edu.io
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-center" id="navbarSupportedContent">
            <ul class="navbar-nav mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active " aria-current="page" href="/">Feed</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/profile">Profile</a>
                </li>
<!--                <li class="nav-item">-->
<!--                    <a class="nav-link" href="/friends">Friends</a>-->
<!--                </li>-->
                <?php
                if($templateData["user_data"] != null && $templateData["user_data"]["role"] >= UserModel::ADMIN){
                    echo '<li class="nav-item">
                            <a class="nav-link" href="/users">Users</a>
                        </li>';
                }
                ?>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="login" id="navbarDropdownMenuLink" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <?php
                            if($templateData["user_data"] == null){
                                ?> Login <?php
                            }else{
                                echo $templateData["user_data"]["username"];
                            }
                        ?>
                    </a>
                    <div class="dropdown-menu navbar-login" >
                        <?php
                        if($templateData["user_data"] == null){
                        ?>
                            <form class="form-horizontal" method="post" action="/" accept-charset="UTF-8">
                                <label>
                                    <input class="form-control login" type="text" name="username" placeholder="Username">
                                </label><br>
                                <label>
                                    <input class="form-control login" type="password" name="password" placeholder="Password">
                                </label><br>
                                <input class="btn btn-primary" type="submit" name="login" value="Login">
                            </form>
                            <div class="dropdown-divider"></div>
                            <a class="navbar-signup" href="/signup">Don't have an account?</a>
                        <?php
                        }else{
                        ?>
                            <form action="/signup" method="POST">
                                <button type="submit" name="logout" class="btn btn-danger" value="logout">Logout</button>
                            </form>
                        <?php
                        }
                        ?>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>

<br>