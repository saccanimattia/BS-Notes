<?php

$server = "localhost";
$usernameDB = "root";
$passwordDB = "";
$databaseName = "bs_notes";

$connection = new mysqli($server, $usernameDB, $passwordDB, $databaseName);
if($connection->connect_error) {
    header("Location: server_malfunction.php");
    exit();
}
