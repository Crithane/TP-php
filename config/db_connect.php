<?php

$conn = mysqli_connect(getenv('DB_HOST') ?? 'localhost', getenv('DB_USER') ?? 'serin', getenv('DB_PASSWORD') ?? 'serin0837', getenv('DB_DATABASE') ?? 'wish_list');

if (!$conn) {
    echo 'Connection error:' . mysqli_connect_error();
} else {
    //echo 'Mysql Connect';
}