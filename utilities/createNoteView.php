<?php 

function createNoteView($row, $isPersonal) {
    $title = $row["titolo"];
    $date = $row["dataAllocazione"];
    $percorso = $row["percorso"];
    $id = $row["id"];
    $body = $row["body"];
    $username = $row["username"];
    $visibilita = $row["visibilita"];
    if(!isset($row["is_amico"]))
        $row["is_amico"] = false;
    if(!isset($row["id_utente"]))
        $row["id_utente"] = false;

    $GLOBALS["notesIcons"] .= "
    <div id='icon$id' class='card s' onclick='trovaAppunti($id)' style='background-color: #0d6efd; border-radius: 10px; padding: 10px 0px 1px 0px; margin-bottom: 25px; margin-right: 10px;'>
        <div style='height: fit-content;'>
            <h4><b>$title</b></h4>
        </div>
        <hr style='width: 70%; background-color: black; margin: 10px auto 10px auto;'>
        <p>$date</p>
    </div>
    ";

    if($isPersonal)
        $dropDownOptions = array(true, true, true, false);
    else 
        $dropDownOptions = array(false, false, true, true);

    return "
        <div class='card mb-1 $id' style='display: none; max-height: 900px; overflow-y: auto;' >
            <div class='positon-relative' style='margin-top: 10px; width: 100%;'>
                <div class='title d-inline-block' style='position: relative; left: 1%;'>
                    <p style='margin-bottom: 0;'>$title</p>
                </div>
                
                <hr id='title_text_divider'>
            </div>
            " .createDropDown(array(
                "id" => $id, 
                "visibilita" => $visibilita, 
                "percorso" => $percorso,
                "title" => $title,
                "is_friend" => $row["is_amico"],
                "id_utente" => $row["id_utente"]
                ), $dropDownOptions) ."
            <div class='card-body'>
                <div id='diagram-container-$id'>
                    $body
                </div>
            </div>
            <div>
                <div class='username-div bg-transparent'>
                    <h6 class='card-title subtitle align-bottom'>Generated on " .date_format(date_create($date), "jS F, Y") ."</h6>
                    <b><p class='card-text mb-1'>$username</p></b>
                </div>
            </div>
        </div>
    ";
}

function createDropdown($arrayData, $arrayFunctions) {
    $visibilita = $arrayData["visibilita"];
    $id = $arrayData["id"];
    $percorso = $arrayData["percorso"];
    $title = $arrayData["title"];
    $is_friend = $arrayData["is_friend"];
    $id_utente = $arrayData["id_utente"];

    $dropDownOptions = "
    <div class='options_container d-inline-block'>
        <i class='bi bi bi-caret-left-fill note_options_opener' id='options_opener_$id'></i>
        <div class='container_options' id='container_options_$id'>
    ";

    /*
    0 => changeVisibility
    1 => delete
    2 => downloadPDF
    3 => friends
    */
    if($arrayFunctions[0]) {
        $dropDownOptions .= "
        <div class='single_option'>
            " .createIcon($id, $percorso, $visibilita) ."
        </div> 
        ";
    }

    if($arrayFunctions[1]) {
        $dropDownOptions .= "
        <div class='single_option'>
            <form action='../utilities/deleteAppunto.php' method='post'>
                <input type='hidden' name='route' value='../routes/myNotes.php'>
                <input type='hidden' name='postId' value='$id'>
                <button class='btn btn-primary button_option' type='submit'><i class='bi bi-trash mr-2'></i>Delete</button>
            </form>
        </div>
        ";
    }

    if($arrayFunctions[2]) {
        $dropDownOptions .= "
        <div class='single_option'>
            <a href='$percorso' download='$title'>
                <button class='btn btn-primary button_option'><i class='bi bi-file-earmark-arrow-down mr-2'></i>Download PDF</button>
            </a>
        </div>
        ";
    }

    if($arrayFunctions[3]) {
        if(!$is_friend) {
            $actionLink = "../utilities/addFriend.php";
            $msg = "Become friend";
            $btnClass = "btn btn-primary";
        }
        else {
            $actionLink = "../utilities/removeFriend.php";
            $msg = "Remove friend";
            $btnClass = "btn btn-danger";
        }
        $dropDownOptions .= "
        <div class='single_option'>
        <form action='$actionLink' method='post'>
            <input type='hidden' name='friendId' value='$id_utente'>
            <input type='hidden' name='route' value='../routes/notes.php'>
            <input type='hidden' name='postId' value='$id'>
            <button type='submit' class='$btnClass button_option'>$msg</button>
        </form>
        </div>
        ";
    }
    
    $dropDownOptions .= "
        </div>
    </div>
    ";

    return $dropDownOptions;
}

function createIcon($id, $percorso, $visibilita) {
    $icona = "
        <form action='../utilities/changeVisibility.php' method='post'>
            <input type='hidden' name='route' value='../routes/myNotes.php'>
            <input type='hidden' name='postId' value='$id'>
            <input type='hidden' name='isOpen' value='true'>
            <input type='hidden' name='pdfPath' value='$percorso'>
            <button class='btn btn-primary 5 button_option' type='submit'>_ICONA__TEXT_</button>
        </form>";

    if($visibilita == "pubblico") {
        $icona = str_replace("_ICONA_", "<i class='bi bi-globe mr-2'></i>", $icona);
        $icona = str_replace("_TEXT_", "Public", $icona);
    } 
    else if($visibilita == "privato"){
        $icona = str_replace("_ICONA_", "<i class='bi bi-lock mr-2'></i>", $icona);
        $icona = str_replace("_TEXT_", "Private", $icona);
    }
    else {
        $icona = str_replace("_ICONA_", "<i class='bi bi-people mr-2'></i>", $icona);
        $icona = str_replace("_TEXT_", "Only friends", $icona);
    }

    return $icona;
}