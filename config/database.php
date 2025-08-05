<?php
function connect_database() {
    $host = "localhost";
    $user = "root";
    $password = "";
    $database = "formulario_db";

    $conn = new mysqli($host, $user, $password, $database);

    if ($conn->connect_error) {
        die("Erro na conexão: " . $conn->connect_error);
    }

    return $conn;
}
