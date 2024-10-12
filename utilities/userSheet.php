<?php

function createUserSheet($user) {
    
    include "../utilities/connection.php";
    
    /*$appunti = $connection->query("
    SELECT 
        ap.titolo as titolo_appunto,
        ap.body as contenuto_appunto,
        ap.dataAllocazione as data_appunto,
        ap.visibilita as visibilita,
        m.nome as materia_appunto,
        c.tipo as tipo
    FROM 
        utente u
    INNER JOIN 
        appunto ap on ap.id_utente = u.id
    INNER JOIN 
        materia m on ap.id_materia = m.id
    INNER JOIN 
        categoria c on ap.id_categoria = c.id
    WHERE 
        u.id = '" .$user["utente_id"] ."'
    ORDER BY 
        ap.dataAllocazione desc
    ")->fetch_all(MYSQLI_ASSOC);

    $i = 0;
    $listaAppunti = "";

    foreach($appunti as $appunto) {
        if($appunto["tipo"] == "riassunto")
            $classIcon = "bi bi-journal-text";
        else 
            $classIcon = "bi bi-diagram-3-fill";

        $listaAppunti .= "
            <div class='noteContainer text-primary mr-1' style='display: none;'>
                <div style='width: 100%'>
                    <i class='$classIcon text-primary d-inline-block mr-2' style='font-size: 20px; height: 25px; width: 6%'></i>
                    <h5 class='d-inline-block text-primary' style='overflow: clip; text-overflow: ellipsis; width: 88%;'> " .$appunto["titolo_appunto"] ."</h5>
                </div>
                <div class='text-light' style='width: 100%;'>
                    <br>
                    <pre class='text-light' style='width: inherit;'>Materia:  " .$appunto["materia_appunto"] ."</pre><br>
                    <pre class='text-light mb-0' style='width: inherit;'>" .$appunto["data_appunto"] ."</pre>
                </div>
            </div>
        ";
        $i++;
    }
    
    echo $listaAppunti;
    */
    $html = "
    <div class='userSheet text-light' id='" .$user["username"] ."_sheet'>
        <div style='text-align: right; height: 6%;'>
            <i class='bi bi-x-lg sheet_closer text-primary' style='cursor: pointer; font-size: 20px;' id='close_" .$user["username"] ."_sheet'></i>
        </div>
        <div style='width: 100%; height: 93%'>
            <div id='informations' class='ml-3' style='height: 25%;'>
                <div class='d-inline-block' style='width: fit-content; position: relative; bottom: 50px;'>
                    <img src='" .$user["percorso"] ."/" .$user["nome_avatar"] .$user["estensione"] ."' style='width: 150px; height: 150px; border-radius: 110px; margin-right: 20px; margin-top: 4px;'>
                </div>
                <div class='d-inline-block pt-2'>
                    <h2 class='d-block'>" .$user["username"] ."</h2><br>
                    <p style='margin-bottom: 5px;'>" .$user["nome_utente"] ."</p>
                    <p>" .$user["cognome"] ."</p>
                </div>
            </div>
            <br>
            <hr style='margin-bottom: 5px;'>
            <div class='userNotes text-primary'>
                <div class='arrow_container'>
                    <button class='btn-no-border text-primary flow-left' id='arrow-left-" .$user["username"] ."'>
                        <i class='bi bi-arrow-left-short'></i>
                    </button>
                </div>
                <div class='table'>
                    <div class='cella1' id='cella-" .$user["username"] ."'></div>
                    <div class='cella2' id='cella-" .$user["username"] ."'></div>
                </div>
                <div class='arrow_container' style='text-align: right;'>
                    <button class='btn-no-border text-primary flow-right' id='arrow-right-" .$user["username"] ."'>
                        <i class='bi bi-arrow-right-short'></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
    ";
    //<i class='d-inline-block bi bi-arrow-right-short text-primary'>
    return $html;
}