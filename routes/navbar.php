<?php

session_start();
$navbar;
if(isset($_SESSION["id"])) {
    $notesGenerator = "Notes Generator";
    $myNotes = "My Notes";
    $othersNotes = "Others Notes";
    $users = "Users";
    $action = setAction(true);

    $navbar = createNavbar($notesGenerator, $myNotes, $othersNotes, $users, $action);
}
else {
    $notesGenerator = "";
    $myNotes = "";
    $othersNotes = "";
    $users = "";
    $action = setAction(false);

    $navbar = createNavbar($notesGenerator, $myNotes, $othersNotes, $users, $action);
}

function createNavbar($notesGenerator, $myNotes, $othersNotes, $users, $action) {
    return '
    <nav style="background-color: rgb(10, 10, 10); z-index: 0;" class="navbar navbar-expand-lg p-2">
        <div class="container-fluid">
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active text-primary" aria-current="page" href="homepage.php">
                            <i class="bi-house"></i>
                            Home
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-primary ml-3" href="notes-generator.php" ' .checkIfshow($notesGenerator) .'>
                            <i class="bi-file-text"></i>
                            ' .$notesGenerator .'
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-primary ml-3" href="myNotes.php" ' .checkIfshow($myNotes) .'>
                            <i class="bi bi-card-text"></i>
                            ' .$myNotes .'
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-primary ml-3" href="notes.php" ' .checkIfshow($othersNotes) .'>
                            <i class="bi bi-collection"></i>
                            ' .$othersNotes .'
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-primary ml-3" href="users.php" ' .checkIfshow($users) .'>
                            <i class="bi bi-people"></i>
                            ' .$users .'
                        </a>
                    </li>
                </ul>
            </div>
            <div class="dropdown">
            ' .$action .'
            </div>
        </div>
    </nav>
    ';
}
function setAction($isLogged) {
    $size = 21;
    if($isLogged == false) {
        $path = "href='login.php'";
        $elem = '
        <svg xmlns="http://www.w3.org/2000/svg" width="' .$size .'" height="' .$size .'" fill="currentColor" class="bi bi-person-fill" viewBox="0 0 16 16">
            <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6"/>
        </svg>
        ';
        $loggedActions = "";
        $temp = "
        <a " .$path ."'>
            <button type='button' id='loginBar' class='btn btn-primary' value='0'>
            " .$elem ."
            </button>
            " .$loggedActions .
        "</a>";
    }
    else {
        include('../utilities/connection.php');
        $query = "SELECT u.*, a.* FROM utente u inner join avatar a on a.id = u.id_avatar WHERE u.id = " .$_SESSION["id"] .";";
        $query = "SELECT u.*, a.* FROM utente u inner join avatar a on a.id = u.id_avatar WHERE u.id = " .$_SESSION["id"] .";";
        $result = $connection->query($query);
        $row = mysqli_fetch_assoc($result);
        $username = $row["username"];
        $elem = "
        <span class='d-inline-block'>" .$username ."</span>
        ";
        $loggedActions = '
        <div style="position: relative; top: 2px; display: inline-block;">
            <li class="nav-item d-inline-block actions">
                <a class="nav-link text-primary ml-3 navitemslogged" style="display: none;" href="../utilities/logout.php?remove=true">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-person-fill-x mb-1" viewBox="0 0 16 16">
                        <path d="M11 5a3 3 0 1 1-6 0 3 3 0 0 1 6 0m-9 8c0 1 1 1 1 1h5.256A4.5 4.5 0 0 1 8 12.5a4.5 4.5 0 0 1 1.544-3.393Q8.844 9.002 8 9c-5 0-6 3-6 4"/>
                        <path d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7m-.646-4.854.646.647.646-.647a.5.5 0 0 1 .708.708l-.647.646.647.646a.5.5 0 0 1-.708.708l-.646-.647-.646.647a.5.5 0 0 1-.708-.708l.647-.646-.647-.646a.5.5 0 0 1 .708-.708"/>
                    </svg>
                    Logout 
                </a>
            </li>
            <li class="nav-item d-inline-block actions">
                <a class="nav-link text-primary ml-3 navitemslogged" style="display: none;" href="friends.php">
                    <i class="bi bi-people-fill"></i>
                    Friends 
                </a>
            </li>
            <li class="nav-item d-inline-block actions">
                <a class="nav-link text-primary ml-3 navitemslogged" style="display: none;" href="settings.php">
                    <i class="bi bi-gear-fill"></i>
                    Settings 
                </a>
            </li>
        </div>
        ';
        $avatarSize = "45px";
        $temp = "
            <div class='d-inline-block' style='position: relative;'>
                <button type='button' id='loginBar' class='btn btn-primary' onmouseenter='showTooltip()' onmouseleave='unshowTooltip()' value='0'>
                " .$elem ."
                </button>
                <span class='tooltiptext'>Click to show settings</span>
            </div>
            <a href='settings.php?avatar=true'><img style='display: inline-block; width: $avatarSize; height: $avatarSize; margin-left: 7px; border-radius: 27px;' src='" .$row["percorso"] ."/" .$row["nome"] .$row["estensione"] ."'></a>
            " .$loggedActions 
            ;
    }
    
    
    return $temp;
}

function checkIfshow($var) {
    if(strcmp($var, "") == 0) {
        return "style='display: none;' disabled";
    }
    else {
        return "style='display: inline-block;'";
    }
}

$iconPath = "../images/logo bs notes.png";
$intestazione = '
<!DOCTYPE html>
<html style="height: 100%;">

    <head>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/mermaid@10.8.0/dist/mermaid.min.js"></script>
        <link rel="stylesheet" href="https://cdn3.devexpress.com/jslib/23.2.3/css/dx.light.css">
        <script type="text/javascript" src="https://cdn3.devexpress.com/jslib/23.2.3/js/dx.all.js"></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
        <link rel="icon" type="image/png" href="' .$iconPath .'">
    </head>
    <body style="background-color: #212529;">
';

$style = "
<style>
    .tooltiptext {
        display: none;
        width: 200px;
        background-color: #616062;
        color: white;
        text-align: center;
        border-radius: 9px;
        position: absolute;
        top: 52px;
        left: -25px;
        padding: 5px 0 7px 0;
        z-index: 1;
    }
    .tooltiptext::after {
        content: '';
        position: absolute;
        bottom: 100%;  /* At the top of the tooltip */
        left: 50%;
        margin-left: -5px;
        border-width: 8px;
        border-style: solid;
        border-color: transparent transparent #616062 transparent;
      }
</style>
";

$script = '
<script>

    visualizzaPagina = (v1, v2, v3) =>{
        divHome.style.display = v1;
        divDashboard.style.display = v2;
        divGrid.style.display = v3;
    }
    
    inserisciClassi = (v1, v2, v3) => {
        const homeLink = document.querySelector("#homeLink");
        const dashboardLink = document.querySelector("#dashboardLink");
        const gridLink = document.querySelector("#gridLink");
    
        togliClasseAttivo(homeLink);
        togliClasseAttivo(dashboardLink);
        togliClasseAttivo(gridLink);
    
        togliClasseNonAttivo(homeLink);
        togliClasseNonAttivo(dashboardLink);
        togliClasseNonAttivo(gridLink);
    
        if (v1 === "attivo") {
            homeLink.classList.add("active");
        }
        if (v2 === "attivo") {
            dashboardLink.classList.add("active");
        }
        if (v3 === "attivo") {
            gridLink.classList.add("active");
        }
    
        homeLink.classList.add(v1);
        dashboardLink.classList.add(v2);
        gridLink.classList.add(v3);
    }
    
    togliClasseAttivo = (elemento) => {
        if (elemento.classList.contains("active")) {
            elemento.classList.remove("active");
            elemento.classList.remove("attivo");
        }
    }
    
    togliClasseNonAttivo = (elemento) => {
        if (elemento.classList.contains("text-primary")) {
            elemento.classList.remove("text-primary");
        }
    }

    $(document).ready(function() {
        $("#loginBar").click(show_hide_settings)
        $("#navbarNav").click(hide_settings)
        $("#homeDiv").click(hide_settings)
    })
    let mytimeout

    function show_hide_settings() {
        let visibility;
        let value = document.getElementById("loginBar")
        console.log(value)
        if(value.value == 0) {
            visibility = "inline"
            value.setAttribute("value" , "1")
        }
        else {
            visibility = "none"
            value.setAttribute("value" , "0")
        }

        const select_menu = document.getElementsByClassName("navitemslogged")
        for(let i=0;i<select_menu.length;i++) {
            select_menu[i].setAttribute("style" , "display: " + visibility + ";")
        }
    }
    function hide_settings() {
        const select_menu = document.getElementById("settings").style
        $(".settings").css("display", "none")
    }
    function showTooltip() {
        mytimeout = setTimeout(function() {
            $(".tooltiptext").fadeIn(600, "swing");
        }, 1300);
    }
    function unshowTooltip() {
        clearTimeout(mytimeout)
        $(".tooltiptext").fadeOut(300, "linear");
    }
</script>';

$pageStarter = $intestazione .$navbar .$script .$style;