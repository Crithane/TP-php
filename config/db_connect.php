<?php

$conn = mysqli_connect('localhost', 'serin', 'serin0837', 'wish_list');

if (!$conn) {
    echo 'Connection error:' . mysqli_connect_error();
} else {
    //echo 'Mysql Connect';
}