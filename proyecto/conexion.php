<?php

$conexion = mysqli_connect("localhost", "root", "", "indieplay");

if (!$conexion) {
    http_response_code(404);
    include 'error.php';
    exit();
}
