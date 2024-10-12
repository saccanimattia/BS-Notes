<?php

session_start();
if(isset($_SESSION['id'])){
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        include('connection.php');
        $postId = $_POST['postId'];
        $route = $_POST['route'];
        $isOpen = $_POST['isOpen'];
        $query = "SELECT visibilita FROM appunto WHERE id = '$postId'";
        $result = mysqli_query($connection, $query);
        $row = mysqli_fetch_assoc($result);
        $visibilita = $row['visibilita'];
        if($visibilita == 'pubblico'){
            $query = "UPDATE appunto SET visibilita = 'solo_amici' WHERE id = '$postId'";
            $result = mysqli_query($connection, $query);
            $route .= "?id=$postId&isOpen=$isOpen";
        }else if($visibilita == 'privato'){
            $query = "UPDATE appunto SET visibilita = 'pubblico' WHERE id = '$postId'";
            $result = mysqli_query($connection, $query);
            if($route != "../routes/notes.php"){
                $route .= "?id=$postId&isOpen=$isOpen";
            }
        }else{
            $query = "UPDATE appunto SET visibilita = 'privato' WHERE id = '$postId'";
            $result = mysqli_query($connection, $query);
            $route .= "?id=$postId&isOpen=$isOpen";
        }
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

?>