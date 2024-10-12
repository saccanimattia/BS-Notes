<?php
 
include('navbar.php');

echo $pageStarter;

if(isset($_SESSION["id"])) {
    $container = "<div class='container-fluid text-light mt-3' style='width: 750px;'>";
    $userSheets = "";

    include('../utilities/connection.php');
    $userId = $_SESSION["id"];

    $sql = "
    SELECT 
        u.id AS utente_id,
        u.nome AS nome_utente,
        u.cognome AS cognome,
        u.username AS username,
        a.nome AS nome_avatar,
        a.estensione AS estensione,
        a.percorso AS percorso
    FROM 
        utente u
    LEFT JOIN 
        amicizia amic ON (u.id = amic.id_utente1 OR u.id = amic.id_utente2)
        AND (amic.id_utente1 = $userId OR amic.id_utente2 = $userId)
    LEFT JOIN 
        avatar a ON u.id_avatar = a.id
    WHERE 
        u.id <> '$userId' and amic.id is not null
    limit 25;
    ";
    $result = $connection->query($sql);
    if($result->num_rows > 0) {
        $friends = $result->fetch_all(MYSQLI_ASSOC);
    }
    else {
        $friends = array();
    }
    
    if(count($friends) == 0) {
        $container .= "
            <h1 style='text-align: center; margin-bottom: 40px;'>You don't have any friends</h1>
        ";
    }
    else {
        include "../utilities/userSheet.php";
        appendFriends($friends, $container, $userSheets);
    }

    $container .= "</div>";
    
}
else{
    include "../utilities/redirect.php";
    redirect("login_required.php");
}

function appendFriends($array, &$container, &$userSheets) {
    foreach($array as $friend) {
        $username = $friend["username"];
        $name = $friend["nome_utente"];
        $surname = $friend["cognome"];
        $idUtente = $friend["utente_id"];

        $avatarName = $friend["nome_avatar"];
        $avatarExtension = $friend["estensione"];
        $avatarPath = $friend["percorso"];

        $container .= "
        <div class='cover'>
            <div class='users opener-user-$username z-0'>
                <div class='d-inline-block' style='margin: auto;'>
                    <div class='d-inline-block'>
                        <img src= '" .$avatarPath ."/" .$avatarName .$avatarExtension ."' style='width: 100px; height: 100px; border-radius: 50px; margin-right: 20px; margin-top: 4px;'>
                    </div>
                    <div class='d-inline-block' style='position: relative; top: 24px; left: 10px;'>
                        <h3 class='text-primary'>$username</h3>
                        <h4>$name $surname</h4>
                    </div>  
                </div>
                <div style='float: right; margin-top: 45px; margin-right: 20px;'>
                    <form action='../utilities/removeFriend.php' method='post'>
                        <input type='hidden' name='friendId' value='$idUtente'>
                        <input type='hidden' name='route' value='../routes/friends.php'>
                        <button type='submit' class='btn btn-danger preventDefault'>Remove friend</button>
                    </form>
                </div>
            </div>
        </div>
        ";

        $userSheets .= createUserSheet($friend);
    }
}

?>

    <title>Friends</title>

    <body>
        <div class='container-fluid text-light mt-3' style='width: 750px;'>
            <div class="mb-5" style=" padding-bottom:1%;text-align: center; font-size: 50px; color:#0077ff">
                <i class="bi bi-people-fill" ></i>
                <strong>Your friends</strong> 
            </div>
            <input class='form-control mb-5' type='search' id='search' onkeyup='search()' placeholder='Type to search..' style='width: 60%; margin: auto; padding: 10px; margin-bottom: 20px; color: black;'>
            <?php echo $container; ?>
        </div>
        <div class="coverUserSheet">
            <?php echo $userSheets; ?>
        </div>
    </body>

    <script>
        const coverUserSheets = document.getElementsByClassName("coverUserSheet")[0]

        window.onload = function() {
            const userDivs = document.getElementsByClassName("users")
            const sheetClosers = document.getElementsByClassName("sheet_closer")

            for(let i=0;i<userDivs.length;i++) {
                userDivs[i].onclick = showUserSheet
                sheetClosers[i].onclick = hideUserSheet
            }
        }

        function showUserSheet(e) {
            let element = e.target
            if(!element.className.includes("preventDefault")) {
                while(!element.className.includes("opener-user-")) {
                    element = element.parentNode
                }
                element = element.className
                let pos = element.indexOf("opener-user-") + 12
                let username = element.substring(pos, element.indexOf(" ", pos))

                coverUserSheets.style.display = "block"
                $("#" + username + "_sheet").css("display", "block")
                $("body").css("overflow", "hidden")
            }
        }
        function hideUserSheet(e) {
            let id = e.target.id
            id = id.replace("close_", "")

            coverUserSheets.style.display = "none"
            document.getElementById(id).style.display = "none"
            $("body").css("overflow-y", "scroll")
        }
        function search() {
            $searchValue = document.getElementById("search").value;
            var divs = document.getElementsByClassName("users");
            for(var i = 0; i < divs.length; i++) {
                var username = divs[i].id;
                if(username.includes($searchValue)) {
                    divs[i].style.display = "block";
                }
                else {
                    divs[i].style.display = "none";
                }
            }
        }
    </script>

    <style>
        .major_container {
            width: 100%;
        }
        .coverUserSheet {
            position: fixed;
            z-index: 3;
            top: 0;
            width: 100%;
            height: 100%;
            backdrop-filter: blur(40px);
            background-color: transparent;
            display: none;
        }
        .userSheet {
            position: relative;
            background-color: #161b22;
            margin: auto;
            margin-top: 4%;
            margin-bottom: 4%;
            height: 80%;
            border: 1px solid #0077ff;
            border-radius: 7px;
            display: none;
            padding: 15px 25px 15px 25px;
            width: 70%;
        }
        .users {
            width: 100%; 
            height: content; 
            margin-bottom: 30px; 
            border: 1px solid white;
            border-radius: 5px; 
            padding: 0 18px 18px 18px;
        }
        .cover {
            cursor: pointer;
            z-index: 1;
        }
    </style>

<?php

    include('finepagina.php');

?>