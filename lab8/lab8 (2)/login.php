<?php

session_start();

// Set Lang
if (isset($_GET["lang"]) && !empty($_GET["lang"]) && in_array($_GET["lang"], array("ua", "en", "es"))) {

    setcookie("lang", $_GET["lang"], time() + 15778463, "/");

    if (isset($_GET["lang"]) && $_COOKIE["lang"] != $_GET["lang"]) {
        echo "<script> window.location.reload(); </script>";
    }
}

if (isset($_COOKIE["lang"])) {
    include "lang/lang_".$_COOKIE["lang"].".php";
} else {
    include "lang/lang_ua.php";
}

?>


<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/login.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <title>Log in</title>
</head>

<body>
    <div class="header">
        <div class="main-area">
            <img class="stonks" src="https://camo.githubusercontent.com/a485ff6a8c645f17c6f7b85035c550f3223215b6/68747470733a2f2f692e696d6775722e636f6d2f495454356877702e706e67">
            <div class="logo">
                <a href="login.html" class="title">MORZHOLYA</a>
            </div>
            <div class="items">
                <a href="#" class="item"> <?= _CREDITCARDS ?> </a>
                <a href="#" class="item"> <?= _LOANS ?> </a>
                <a href="about.php" class="item"> <?= _ABOUTUS ?> </a>
                <a href="contactus.html" class="item"> <?= _CONTACTUS ?> </a>
            </div>
        </div>
        <div class="lang">
            <form action="" method="get" id="form_lang">
                <select class="form-control form-control-sm" name="lang" onchange="changeLang();">
                    <option value="ua" <?php if (isset($_COOKIE["lang"]) && $_COOKIE["lang"] == "ua") { echo "selected";} ?> >Українська</option>
                    <option value="en" <?php if (isset($_COOKIE["lang"]) && $_COOKIE["lang"] == "en") { echo "selected";} ?>>English</option>
                    <option value="es" <?php if (isset($_COOKIE["lang"]) && $_COOKIE["lang"] == "es") { echo "selected";} ?>>Español</option>
                </select>
            </form>
        </div>
    </div>
    <div class="main-container">
        <div class="bank-info">
            <p> <?= _BANKINFO1 ?> </p>
            <p> <?= _BANKINFO2 ?> </p>
            <p> <?= _BANKINFO3 ?> </p>
        </div>
        <div class="signin">
            <form action="auth.php" class="signin-form" method="post">
                <h2> <?= _LOGIN ?> </h2>
                <label>
                    <input name="login" class="input-field" type="text" placeholder=" <?= _BANKID ?> ">
                </label>
                <label>
                    <input name="password" class="input-field" type="password" placeholder=" <?= _PASSWORD ?> ">
                </label>
                <input class="sumbit-btn" type="submit" value=" <?= _LOGIN ?> ">
            </form>
        </div>
    </div>

    <script>
        function changeLang() {
            document.getElementById("form_lang").submit();
        }
    </script>

</body>

</html>