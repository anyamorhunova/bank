<?php
    
    $inp = $_POST['ourForm_inp'];

    switch($inp){
    case 'Admin':
        echo'Welcome Admin';
        break;
    case 'User':
        echo 'Welcome User';
        break;
    default:
        echo 'NONE';
}
