<?php
function db_connect() {
    $host = 'localhost';
    $user = 'root';
    $pass = '';
    $dbname = 'latihan_11';

    $conn = new mysqli($host, $user, $pass, $dbname);

    if ($conn->connect_error) {
        die('Connection failed: ' . $conn->connect_error);
    }

    return $conn;
}
?>