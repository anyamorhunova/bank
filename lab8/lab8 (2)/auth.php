<?php
    session_start();
    if($_POST['login'] != '' && $_POST['password'] != '') { //проверяем пустые ли поля авторизации
        $login = trim(strip_tags($_POST['login']));//трим-убирает пробелы 
        $password = trim(strip_tags($_POST['password']));//стрип - убирает некоректные символы(например сравнение или решетку)
        $_SESSION["user"] = $login;
        header("Location: /lab8.php");
    }
?>