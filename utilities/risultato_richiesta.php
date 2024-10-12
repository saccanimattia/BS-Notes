<?php

include "redirect.php";
include('../routes/navbar.php');

if($_SERVER["REQUEST_METHOD"] == "GET") {
    $res = $_GET["res"];
    if($res == "true") {
        $visibleSuccess = "block";
        $visibleDanger = "none";
    }
    else {
        $visibleSuccess = "none";
        $visibleDanger = "block";
    }
}
else {
    redirect("err500.php");
}

echo $pageStarter;

?>

<div class="cover">
    <div class="result bg-success text-light text-center" style='display: <?php echo $visibleSuccess; ?>;'>
        <p style="font-size: 22px;">Your assistance request has been received successfully!</p>
        <a href="../routes/homepage.php" class="btn text-center actionButtons" role="button" style="width: 100px;">Homepage</a>
    </div>
    <div class="result bg-danger text-light text-center" style='display: <?php echo $visibleDanger; ?>;'>
        <p style="font-size: 22px;">Something wrong with your request, please try again later</p>
        <a href="../routes/homepage.php" class="btn text-center actionButtons" role="button" style="width: 100px;">Homepage</a>
    </div>
</div>

<style>
    .cover {
        width: 100%;
        height: 100%;
        background-color: #212529;
        position: fixed;
    }
    .result {
        width: 600px;
        height: 125px;
        position: fixed;
        top: 50%;
        left: 50%;
        margin: -65px 0 0 -300px;
        border: 1px solid white;
        border-radius: 7px;
        padding: 10px 10px 10px 10px;
    }
    .actionButtons {
        background-color: white; 
        opacity: 100%;
        color: black;
        text-align: center;
    }
    .actionButtons:hover {
        background-color: deepskyblue; 
        opacity: 100%;
        color: black;
    }
</style>