<?php
//функция для того чтобы получить записи о таблице "день"
function get_day($link){
    $sqld = "SELECT * FROM `day`";
    $resultd = mysqli_query($link, $sqld);
    $day = mysqli_fetch_all($resultd, MYSQLI_ASSOC);
    return $day;
}

$day = get_day($link);

function get_program($link){
    $sqlp = "SELECT * FROM `program`";
    $resultp = mysqli_query($link, $sqlp);
    $program = mysqli_fetch_all($resultp, 1);
    return $program;
}

$program = get_program($link);

/*
 * function get_connection($link){
    $sqlc = "SELECT * FROM `connection`";
    $resultc = mysqli_query($link, $sqlc);
    $connection = mysqli_fetch_all($resultc, MYSQLI_ASSOC);
    return $connection;
}

$connection = get_connection($link);
 */
function get_information_into_program($link, $name){
    $name = mysqli_real_escape_string($link, $name);
    //1. проверить есь ли уже такая программа в БД
    $query = "SELECT * FROM `day` WHERE name = '$name'";
    $result = mysqli_query($link, $query);

    
    
    if (!$result || mysqli_num_rows($result)){
        $num = 3;
        //2. если ее нет, то добавляем
        $insert_query = "INSERT INTO day (ID, title) VALUES ('$num', '$name')";
        $result = mysqli_query($link, $insert_query);
        $num += 1;
        var_dump($result);
        if ($result){
            //1. проверить добавилась ли такая программа в БД
            echo 'created';
            return 'created';
        }
        else{
            echo 'fail';
            return 'fail';
        }
    }else{
        //3. если есть
        echo 'fail';
        return 'fail';
    }
}
?>