<?php

include "../utilities/connection.php";
function populateSubjects() {
    $arraySubjects = $GLOBALS["connection"]->query("select id, nome from materia;")->fetch_all(MYSQLI_ASSOC);
    usort($arraySubjects, "sortBySubject");
    $html = "";
    foreach($arraySubjects as $subject) {
        $html .= "<option value='" .$subject["id"] ."'>" .$subject["nome"] ."</option>";
    }
    return $html;
}
function populateLanguages() {
    $html = "";
    $languages = $GLOBALS["connection"]->query("select language, code from lingua;")->fetch_all(MYSQLI_ASSOC);
    usort($languages, 'sortByLanguage');
    $preferredLang = explode(";", explode(",", $_SERVER['HTTP_ACCEPT_LANGUAGE'])[1])[0];
    for($i=0;$i<count($languages);$i++) {
        if($preferredLang == $languages[$i]["code"])
            $sel = "selected";
        else 
            $sel = "";
        $html .= "<option $sel value='" .$languages[$i]["language"] ."'>" .$languages[$i]["language"] ." - " .$languages[$i]["code"] ."</option>";
    }
    return $html;
}

function sortByLanguage($a, $b) {
    return strcmp($a['language'], $b['language']);
}

function sortBySubject($a, $b) {
    return strcmp($a['nome'], $b['nome']);
}