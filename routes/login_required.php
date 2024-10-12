<?php 
    include "../routes/navbar.php";
    echo $pageStarter;
?>

    <div class="border border-3 rounded rounded-5 border-primary p-4" style="width: 70%; margin: auto; margin-top: 130px;">
        <div style="font-size: 40px; color:#0077ff; text-align: center;  margin-bottom: 30px;">
            <i class="bi bi-question-circle"></i>
            <strong>You must be logged in to use this service!</strong>
        </div>
        <div style="margin-bottom: 15px;">
            <div class="d-inline-block" style="width: 49%; text-align: right; padding-right: 50px;">
                <a href="signup.php" class="btn text-center actionButtons" role="button" style="width: 100px;">Sign up</a>
            </div>
            <div class="d-inline-block" style="width: 50%; padding-left: 50px;">
                <a href="login.php" class="btn text-center actionButtons" role="button" style="width: 100px; ">Login</a>
            </div>
        </div>
    </div>

    <style>
        .actionButtons {
            background-color: #007bff; 
            opacity: 100%;
            color: rgb(240, 240, 240);
        }
        .actionButtons:hover {
            background-color: deepskyblue; 
            opacity: 100%;
            color: #000000;
        }
    </style>