<?php

session_start();
if(isset($_SESSION['id'])){
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        include('connection.php');
        $postId = $_POST['postId'];
        $route = $_POST['route'];
        $path = $_POST["pdfPath"];
        $query = "DELETE FROM appunto WHERE id = '$postId'";
        $result = mysqli_query($connection, $query);
        unlink("$path");
        header("Location: $route");
    }
    else{
        include('redirect.php');
        redirect('err400.php');
    }
}else{
    include('redirect.php');
    redirect('err400.php');
}

