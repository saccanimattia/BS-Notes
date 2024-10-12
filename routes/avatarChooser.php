<?php 

session_start();
if(isset($_SESSION["id"])) {
    include "../utilities/connection.php";
    include "chooseAvatar.php";
}
else {
    include "../utilities/redirect.php";
    redirect("login_required.php");
}

?>

<html>
    <head>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="https://cdn3.devexpress.com/jslib/23.2.3/css/dx.light.css">
        <script type="text/javascript" src="https://cdn3.devexpress.com/jslib/23.2.3/js/dx.all.js"></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
        <link rel="icon" type="image/png" href="' .$iconPath .'">
    </head>
    
    <body style="background-color: #212529;">
        <div style="width: 75%; margin: auto;">
            <?php echo $containerAvatars; ?>
        </div>
    </body>
</html>