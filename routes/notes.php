<?php

include('navbar.php');

echo $pageStarter;

function showAutorizedNotes($result){
    $result = mysqli_fetch_all($result, MYSQLI_ASSOC);
    for($i=0;$i<count($result);$i++){
        if($result[$i]["visibilita"] == "solo_amici" && $result[$i]["is_amico"] == false){          
            unset($result[$i]);
        }
    }
    $result = array_values($result);
    return $result;
}

if (isset($_SESSION["id"])) {
    include('../utilities/connection.php');
    $user = $_SESSION["id"];
    $notesIcons = "";
    $container = "<div>";

    $query = "
    SELECT 
        a.id, 
        a.titolo, 
        a.percorso, 
        a.dataAllocazione, 
        a.id_materia, 
        a.id_categoria, 
        a.body, 
        a.visibilita,
        a.id_utente, 
        u.username,
        IF(amic.id IS NOT NULL, TRUE, FALSE) AS is_amico
    FROM 
        appunto a join utente u on a.id_utente = u.id
    LEFT JOIN 
        amicizia amic ON (u.id = amic.id_utente1 OR u.id = amic.id_utente2)
        AND (amic.id_utente1 = $user OR amic.id_utente2 = $user)
    WHERE 
        a.visibilita <> 'privato' and a.id_utente <> $user
    ORDER BY 
        a.dataAllocazione desc 
    ";
    $result = mysqli_query($connection, $query);
    $gray = 220;

    if (mysqli_num_rows($result) > 0) {
        $result = showAutorizedNotes($result);
    }
    else {
        $result = array();
    }

    if (count($result) > 0){
        include "../utilities/createNoteView.php";
        foreach($result as $row) {
            $container .= createNoteView($row, false);
        }
        $container .= "</div>";
    }   
   
}
else {
    include "../utilities/redirect.php";
    echo redirect("login_required.php");
}

?>
    <title>Others Notes</title>
    <div>
        <div id="gridDiv" style="margin-top:2%; ">
            <div style="float: left; width:30%; margin-right:2%; ">
                <h1 class="text-primary"><b>Others Notes</b></h1><br>
                <div style='margin: auto; width: 80%; margin-bottom: 40px;'>
                    <input class="form-control mr-sm-2 search" type="search" id="search" onchange="search()" placeholder="Type and press enter to search">
                </div>
                <div style="height: 500px; overflow-y:auto;">
                    <?php echo $notesIcons; ?>
                </div>
            </div>
            <div class="appunto" style="float: right; width:62%;">
                <h1 class="text-primary"><b>Selected Note</b></h1><br>
                <div class="card text-danger 0" style=" display: block;">
                    <div class="card-header bg-transparent title">
                        <p>Nessun appunto selezionato</p>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title subtitle">Seleziona un appunto per visualizzarne il contenuto</h5>
                    </div>
                </div>
                <?php echo $container ?>
            </div>
        </div>
    </div>

    <link rel="stylesheet" href="../utilities/cssNotes.css">
    <script src="../utilities/jsNotes.js"></script>

<?php
     if($_SERVER["REQUEST_METHOD"] == "GET") {
        if(isset($_GET["id"])) {
            $postId = intval($_GET["id"]);
            echo "<script>trovaAppunti($postId)</script>";
            if(isset($_GET["isOpen"])) {
                $isOpen = $_GET["isOpen"];
                if($isOpen == "true") {
                    echo "<script>changeOptionsVisibility($postId, 'inline-block', 'bi-caret-left-fill', 'bi-caret-down-fill')</script>";
                }
            }
        }
    }
    include('finepagina.php');
?>  