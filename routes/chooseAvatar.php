<?php

$avatars = "";
function getAvatars() {
    $sql = "select nome, estensione, percorso from avatar;";
    return $GLOBALS["connection"]->query($sql)->fetch_all(MYSQLI_ASSOC);
}

if($_SERVER["REQUEST_METHOD"] == "GET") {
    $avatarList = getAvatars();
    $userAvatar = $connection->query("select a.nome from avatar a inner join utente u on u.id_avatar = a.id where u.id = " .$_SESSION["id"] .";")->fetch_assoc();
    if(isset($userAvatar["nome"])) {
        displayAvatars($userAvatar["nome"], $avatarList, $avatars);
    }
    else
        displayAvatars(null, $avatarList, $avatars);
    $containerAvatars = '
        <div class="mt-3" style=" padding-bottom:1%;text-align: center; font-size: 50px; color:#0077ff">
            <i class="bi bi-person-circle d-inline-block"></i>
            <strong class="d-inline-block">Choose your avatar</strong> 
        </div>
        <div style="min-width: 30%; max-width: 80%; margin-left: auto; margin-right: auto;" class="text-light border border-3 rounded rounded-5 border-primary p-4 mt-2">
            <div style="text-align: center; padding-top: 30px; padding-bottom: 0;">
                <form action="chooseAvatar.php" method="POST">
                    ' .$avatars .'
                </form>
            </div>
        </div>
    </div>

    <style>
        .avatar {
            width: 225px;
            height: 225px;
            border-radius: 30px;
            border: 2px solid white;
        }
        .avatar_without_ml {
            width: fit-content;
            display: inline-block;
            margin-bottom: 33px;
        }
        .avatar_container {
            width: fit-content;
            display: inline-block;
            margin-bottom: 33px;
            margin-left: 30px;
        }
        body {
            padding-bottom: 35px;
        }
    </style>
    ';
}
else if($_SERVER["REQUEST_METHOD"] == "POST") {
    include('../utilities/connection.php');
    include "../utilities/redirect.php";
    session_start();
    $avatarList = getAvatars();

    $avatar = $_POST["avatar"];
    $wrongParam = true;
    for($i = 0; $i < count($avatarList); $i++) {
        if($avatarList[$i]["nome"] == $avatar) {
            $wrongParam = false;
            $avatarId = $connection->query("select id from avatar where nome = '" .$avatarList[$i]["nome"] ."';")->fetch_assoc()["id"];
            $connection->query("update utente set id_avatar = '$avatarId' where id = '" .$_SESSION["id"] ."';");
            break;
        }
    }
    if($wrongParam == true) {
        redirect("login_required.php");
    }
    else {
        redirect("settings.php?avatar=true");
    }
}

function isChosen($avatar, $userAvatar) {
    if($avatar == $userAvatar) {
        return "disabled";
    }
}

function displayAvatars($avatarUser, $avatarList, &$avatars) {
    for($i = 0; $i < count($avatarList); $i++) {
        if($i%3 == 0)
            $class = "class='avatar_without_ml'";
        else 
            $class = "class='avatar_container'";
        
        $avatars .= "
                <div $class>
                    <img style='display: block;' class='avatar' src='" .$avatarList[$i]["percorso"] ."/" .$avatarList[$i]["nome"] .$avatarList[$i]["estensione"] ."'>
                    <button " .isChosen($avatarList[$i]["nome"], $avatarUser) ." class='btn btn-primary mt-3' type='submit' name='avatar' value='" .$avatarList[$i]["nome"] ."'>Choose</button>
                </div>
        ";
    }
}
