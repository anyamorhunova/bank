<?php
//прописываем подключение к БД
$link = mysqli_connect('localhost', 'mysql', 'mysql', 'lab7');

// проверка на подключение к БД, если не подключилось вывести текст ошибки
if(mysqli_connect_errno()){
    echo 'Didn`t connect'.mysqli_connect_error();
    exit;
}