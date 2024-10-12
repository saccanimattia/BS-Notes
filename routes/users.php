<?php
 
include('navbar.php');

echo $pageStarter;

if(isset($_SESSION["id"])) {
    include('../utilities/connection.php');
    $userId = $_SESSION["id"];
    $container = "<div>";
    $userSheets = "";

    $sql = "
    SELECT 
        u.id AS utente_id,
        u.nome AS nome_utente,
        u.cognome AS cognome,
        u.username AS username,
        a.nome AS nome_avatar,
        a.estensione AS estensione,
        a.percorso AS percorso,
        IF(amic.id IS NOT NULL, TRUE, FALSE) AS is_amico
    FROM 
        utente u
    LEFT JOIN 
        amicizia amic ON (u.id = amic.id_utente1 OR u.id = amic.id_utente2)
        AND (amic.id_utente1 = $userId OR amic.id_utente2 = $userId)
    LEFT JOIN 
        avatar a ON u.id_avatar = a.id
    WHERE 
        u.id <> '$userId'
    limit 25;
    ";
    $users = $connection->query($sql)->fetch_all(MYSQLI_ASSOC);
    if(count($users) != 0) {
        include "../utilities/userSheet.php";
        appendusers($users, $container, $userSheets);
    }
}
else{
    include "../utilities/redirect.php";
    redirect("login_required.php");
}

function appendusers($array, &$container, &$userSheets) {
    foreach($array as $user) {
        $username = $user["username"];
        $name = $user["nome_utente"];
        $surname = $user["cognome"];
        $idUtente = $user["utente_id"];

        $avatarName = $user["nome_avatar"];
        $avatarExtension = $user["estensione"];
        $avatarPath = $user["percorso"];
        $isFriend = $user["is_amico"];

        if($isFriend == 0) {
            $actionLink = "../utilities/addFriend.php";
            $msg = "Become friend";
            $btnClass = "btn btn-primary";
        }
        else {
            $actionLink = "../utilities/removeFriend.php";
            $msg = "Remove friend";
            $btnClass = "btn btn-danger";
        }

        $action = "
        <div style='float: right; margin-top: 45px; margin-right: 20px; z-index: 2;'>
            <form action='$actionLink' method='post'>
                <input type='hidden' name='friendId' value='$idUtente'>
                <input type='hidden' name='route' value='../routes/users.php'>
                <button type='submit' class='$btnClass preventDefault'>$msg</button>
            </form>
        </div>
        ";

        $container .= "
        <div class='cover'>
            <div class='users opener-user-$username z-0' id='$username'>
                <div class='d-inline-block' style='margin: auto;'>
                    <div class='d-inline-block'>
                        <img src= '" .$avatarPath ."/" .$avatarName .$avatarExtension ."' style='width: 100px; height: 100px; border-radius: 50px; margin-right: 20px; margin-top: 4px;'>
                    </div>
                    <div class='d-inline-block' style='position: relative; top: 24px; left: 10px;'>
                        <h3 class='text-primary'>$username</h3>
                        <h4>$name $surname</h4>
                    </div>  
                </div>
                $action
                
            </div>
        </div>
        ";

        $userSheets .= createUserSheet($user);
    }
    $container .= "</div>";
}

?>
    <title>Discover people</title>

    <div class="major_container">
        <div class='container-fluid text-light mt-3 z-0 d-block' style='width: 55%;'>
            <div class="mb-5" style=" padding-bottom:1%;text-align: center; font-size: 50px; color:#0077ff">
                <i class="bi bi-people" ></i>
                <strong>Discover new people</strong> 
            </div>
            <input class='form-control mb-5' type='search' id='search' onkeyup='search()' placeholder='Type to search..' style='width: 60%; margin: auto; padding: 10px; margin-bottom: 20px; color: black;'>
            <?php echo $container; ?>
        </div>
        <div class="coverUserSheet">
            <?php echo $userSheets; ?>
        </div>
    </div>

    <script>
        const coverUserSheets = document.getElementsByClassName("coverUserSheet")[0]

        const currentNotes = []
        const shownNotes = []
        let lastDiv = 0
        let firstDiv = 0

        window.onload = function() {
            const userDivs = document.getElementsByClassName("users")
            const sheetClosers = document.getElementsByClassName("sheet_closer")

            for(let i=0;i<userDivs.length;i++) {
                userDivs[i].onclick = showUserSheet
                sheetClosers[i].onclick = hideUserSheet
            }

        }

        async function showUserSheet(e) {
            let element = e.target
            let username

            if(!element.className.includes("preventDefault")) {
                while(!element.className.includes("opener-user-")) {
                    element = element.parentNode
                }
                element = element.className
                let pos = element.indexOf("opener-user-") + 12
                username = element.substring(pos, element.indexOf(" ", pos))

                coverUserSheets.style.display = "block"
                $("#" + username + "_sheet").css("display", "block")
                $("body").css("overflow", "hidden")
            }

            const notes = await fetchData(
                `SELECT 
                    ap.titolo AS titolo_appunto,
                    ap.dataAllocazione AS data_appunto,
                    ap.visibilita AS visibilita,
                    m.nome AS materia_appunto,
                    c.tipo AS tipo
                FROM 
                    utente u
                INNER JOIN 
                    appunto ap ON ap.id_utente = u.id
                INNER JOIN 
                    materia m ON ap.id_materia = m.id
                INNER JOIN 
                    categoria c ON ap.id_categoria = c.id
                LEFT JOIN 
                    amicizia a1 ON u.id = a1.id_utente1
                LEFT JOIN 
                    amicizia a2 ON u.id = a2.id_utente2
                WHERE 
                    u.username = '${username}' AND 
                    (ap.visibilita = 'pubblico' OR 
                    (ap.visibilita = 'solo_amici' AND 
                    (ap.id_utente IN (
                        SELECT 
                            CASE 
                                WHEN a1.id_utente1 = u.id THEN a1.id_utente2
                                WHEN a2.id_utente2 = u.id THEN a2.id_utente1
                            END 
                        FROM 
                            amicizia a1
                        LEFT JOIN 
                            amicizia a2 ON a1.id_utente1 = a2.id_utente2
                        WHERE 
                            a1.id_utente1 = u.id OR 
                            a2.id_utente2 = u.id
                    ))))
                ORDER BY 
                    ap.dataAllocazione DESC;`
            )
            for(let i=0;i<notes.length;i++)
                currentNotes.push(notes[i])
            
            $(".flow-left#arrow-left-" + username).prop("disabled", true)
            $(".flow-left#arrow-left-" + username).click(flowLeft)
            $(".flow-right#arrow-right-" + username).click(flowRight)
            putDivs(username)
        }
        function hideUserSheet(e) {
            let id = e.target.id
            id = id.replace("close_", "")

            coverUserSheets.style.display = "none"
            document.getElementById(id).style.display = "none"
            $("body").css("overflow-y", "scroll")

            currentNotes.splice(0, currentNotes.length)
            shownNotes.splice(0, shownNotes.length)
            firstDiv = 0
            lastDiv = 0
            let username = id.replace("_sheet", "")
            $(".flow-left#arrow-left-" + username).off("click", flowLeft)
            $(".flow-right#arrow-right-" + username).off("click", flowRight)
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

        function putDivs(username) {
            for(let i=0;(i<currentNotes.length && i<2);i++) {
                shownNotes.push(currentNotes[i])
            }
            lastDiv = shownNotes.length - 1

            displayResult(username)
            if(shownNotes.length == currentNotes.length)
                $(".flow-right#arrow-right-" + username).prop('disabled', true)
            else 
                $(".flow-right#arrow-right-" + username).prop('disabled', false)
        }
        function flowLeft(e) {
            let username = e.currentTarget.id.substring(11)
            
            if(firstDiv == 0)
                $(".flow-left#arrow-left-" + username).prop('disabled', true)
            else {
                shownNotes.pop()
                firstDiv--
                shownNotes.unshift(currentNotes[firstDiv])
                lastDiv--
                $(".flow-right#arrow-right-" + username).prop('disabled', false)
                displayResult(username)
                if(firstDiv == 0)
                    $(".flow-left#arrow-left-" + username).prop('disabled', true)
            }
            
        }
        function flowRight(e) {
            let username = e.currentTarget.id.substring(12)

            if(lastDiv == currentNotes.length - 1)
                $(".flow-right#arrow-right-" + username).prop('disabled', true)
            else {
                shownNotes.shift()
                firstDiv++
                lastDiv++
                shownNotes.push(currentNotes[lastDiv])
                $(".flow-left#arrow-left-" + username).prop('disabled', false)
                displayResult(username)
                if(lastDiv == currentNotes.length - 1)
                    $(".flow-right#arrow-right-" + username).prop('disabled', true)
            }
        }
        function displayResult(username) {
            console.log(shownNotes)
            for(let i=0;i<shownNotes.length;i++) {
                let note = shownNotes[i]
                let noteContainer = document.createElement("div")
                noteContainer.className = "noteContainer text-primary mr-1"

                noteContainer.style.display = "inline-block"
                noteContainer.style.width = "100%"
                noteContainer.style.marginTop = "15px"

                noteContainer.innerHTML = `
                    <div style='width: 100%'>
                        <i class='bi ${note["tipo"] == "riassunto" ? "bi-journal-text" : "bi-diagram-3-fill"} text-primary d-inline-block mr-2' style='font-size: 20px; height: 25px; width: 6%'></i>
                        <h5 class='d-inline-block text-primary' style='overflow: clip; text-overflow: ellipsis; width: 88%;'> ${note["titolo_appunto"]} </h5>
                    </div>
                    <div class='text-light' style='width: 100%;'>
                        <br>
                        <pre class='text-light' style='width: inherit;'>Materia:  ${note["materia_appunto"]} </pre><br>
                        <pre class='text-light
                        mb-0' style='width: inherit;'>${note["data_appunto"].substring(0, 10)} </pre>
                    </div>
                `
                const cella = $(".cella" + (i+1) + "#cella-" + username)
                cella.empty()
                cella.append(noteContainer)
            }
        }

        async function fetchData(sql) {
            try {
                const response = await fetch(`http://localhost:3000/queryDatabase?sql=${encodeURIComponent(sql)}`)
                const data = await response.json()
                return data
            } catch (error) {
                return null
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
        .noteContainer {
            width: 100%;
            height: 100%;
            border: 1px solid white;
            border-radius: 5px;
            padding: 10px 15px 5px 15px;
            display: inline-block;
        }
        .userNotes {
            height: 63%;
            width: 90%;
            margin: auto;
        }
        .table {
            height: 100%;
            width: 85%;
            margin-top: 80px;
            float: left;
        }
        .table * {
            width: 49%;
            display: inline-block;
        }
        .arrow_container {
            height: 100%;
            width: 7%;
            float: left;
            margin: auto;
            font-size: 50px;
            position: relative;
            top: 130px;
        }
        .btn-no-border {
            border: none;
            background-color: transparent;
        }
        .btn-no-border:focus {
            outline: none;
        }
        .btn-no-border:disabled {
            opacity: 0.5;
        }
        .cella1 {
            margin-right: 11px;
        }
    </style>

<?php
    include('finepagina.php');
?>