<?php

    include('navbar.php');

    echo $pageStarter;

    $icon = '<svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" class="bi bi-clipboard2-check d-inline-block text-primary mr-5 mb-5" viewBox="0 0 16 16">
                    <path d="M9.5 0a.5.5 0 0 1 .5.5.5.5 0 0 0 .5.5.5.5 0 0 1 .5.5V2a.5.5 0 0 1-.5.5h-5A.5.5 0 0 1 5 2v-.5a.5.5 0 0 1 .5-.5.5.5 0 0 0 .5-.5.5.5 0 0 1 .5-.5z"/>
                    <path d="M3 2.5a.5.5 0 0 1 .5-.5H4a.5.5 0 0 0 0-1h-.5A1.5 1.5 0 0 0 2 2.5v12A1.5 1.5 0 0 0 3.5 16h9a1.5 1.5 0 0 0 1.5-1.5v-12A1.5 1.5 0 0 0 12.5 1H12a.5.5 0 0 0 0 1h.5a.5.5 0 0 1 .5.5v12a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5z"/>
                    <path d="M10.854 7.854a.5.5 0 0 0-.708-.708L7.5 9.793 6.354 8.646a.5.5 0 1 0-.708.708l1.5 1.5a.5.5 0 0 0 .708 0z"/>
                </svg>';
    $titleIcon = '<svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-arrow-return-right d-inline-block mb-1 mr-3 ml-2" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M1.5 1.5A.5.5 0 0 0 1 2v4.8a2.5 2.5 0 0 0 2.5 2.5h9.793l-3.347 3.346a.5.5 0 0 0 .708.708l4.2-4.2a.5.5 0 0 0 0-.708l-4-4a.5.5 0 0 0-.708.708L13.293 8.3H3.5A1.5 1.5 0 0 1 2 6.8V2a.5.5 0 0 0-.5-.5"/>
                </svg>';
?>

<title>Home</title>
<div id="container" class="text-light mt-3" style="width: 100%; mb-1">

    <div class="text-start mb-0 ml-4" style="width: 90%;">
        <h1 class="text-primary mb-1" style="font-size: 80px;">BS Notes</h1>
        <?php echo $titleIcon; ?><h5 class="mt-0 d-inline-block">Your partner to create and organise your notes, where and whenever you want</h5>
    </div>

    <div style="margin-top: 90px;">
        <div class="text-start ml-2" style="width: 59%; float: left;">
            <ul style="list-style-type: none;">
                <li><?php echo $icon; ?><p class="d-inline-block" style="position: relative; bottom: 22px;">Give a topic, we'll generate the best result for you</p></li>
                <li><i class="bi bi-box-arrow-up-right d-inline-block text-primary mr-5 ml-1 mb-5" style="font-size: 35px;"></i><p class="d-inline-block" style="position: relative; bottom: 6px;">Make your notes public or share them to your friends</p></li>
                <li><i class="bi bi-calendar4-event d-inline-block text-primary mr-5 mb-4" style="font-size: 35px; margin-left: 2px;"></i><p class="d-inline-block" style="position: relative; bottom: 6px;">Fill your personal calendar to find your notes more easily<p></li>
                <li><i class="bi bi-arrow-clockwise text-primary mr-5 mt-0" style="font-size: 40px; position: relative; right: 1px;"></i><p class="d-inline-block"  style="position: relative; bottom: 12px;">If not satisfied, you can simply regenerate your notes</p></li>
            </ol>
        </div>

        <?php

            if (!isset($_SESSION['id'])) {
                echo '<div class="float-end" style="width: 40%; float: left;">
                <div style="width: 80%; text-align: left;"> 
                    <h3 class="text-center">Get started now</h3>
                    <hr style="background-color: deepskyblue; margin-left: 0; height: 2px;">
                    <p class="d-inline-block mt-2">Are you new to BS Notes?<br> Sign up in a few steps, it\'s easy and for free</p>
                    <a href="signup.php" class="btn text-center actionButtons d-inline-block ml-5" role="button" style="width: 100px; margin-bottom: 28px;">Sign up</a>
                    <p class="d-inline-block mt-4">Already have an account?</p>
                    <a href="login.php" class="btn text-center actionButtons d-inline-block mb-1 ml-5" role="button" style="width: 100px;">Login</a>
                </div>
            </div>';
            }
        ?>
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

<?php include('finepagina.php'); ?>