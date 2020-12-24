<?php
require_once 'app/include/database.php';
require_once 'app/include/functions.php';
//isset - check if exist
if (isset($_POST['name'])){
    //work with information
    $name = trim($_POST['name']);
    //функция работы над мейлом
    $insert_information = get_information_into_program($link, $name);
    
 /*   switch($insert_information){
        case 'fail': header('Location: /');
        break;
        case 'exists': header('Location: /');
        break;
        case 'created': header('Location: /');
        break;
    }
  */ 
} else{
    header('Location: /');
}
?>