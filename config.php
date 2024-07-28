<?php
$servername = "desafio-tecnico.cf1afo0ns4vr.us-west-2.rds.amazonaws.com";
$username = "matheus_henrique";
$password = "DesafioAvant@2024";
$dbname = "matheus_henrique"; 

/
$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}


if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
