<?php

include "redirect.php";
session_start();

if($_SERVER["REQUEST_METHOD"] == "POST") {

    $_SESSION["note"] = $_POST["note"];
    $_SESSION["noteGenerated"] = $_POST["map"];
    $_SESSION["isPublic"] = $_POST["isPublic"];
    $_SESSION["subject"] = $_POST["subject"];
    $_SESSION["noteType"] = $_POST["type"];
}
else {
    redirect("err500.php");
}