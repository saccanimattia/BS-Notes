<?php

    include('connection.php');
    session_start();
    if(isset($_SESSION["id"])){
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $pdf = $_FILES['pdf'];
            $pdfName = $_POST['title'];
            $materia = $_POST['materia'];
            $contenuto = $_POST['html'];
            $categoria = $_POST['categoria'];
            $contenuto = $connection->real_escape_string($contenuto);
            $pdfTmpName = $pdf['tmp_name'];
            $random_sequence = rand(100000, 999999);
            $random_start = "_$";
            $pdfSaveName = $pdfName . $random_start . $random_sequence ;
            if($categoria == '1'){
                $folder = 'maps';
            }
            else if($categoria == '2'){
                $folder = 'summaries';
            }
            $path = '../'.$folder.'/' . $pdfSaveName . '.pdf';
            $visibilita = $_POST['visibilita'];
            
            if(move_uploaded_file($pdfTmpName, $path)) {
               $id = $_SESSION['id'];
               $sql = "INSERT INTO appunto (titolo, body, percorso, dataAllocazione, id_materia, id_utente, id_categoria, visibilita) VALUES ('{$pdfName}', '{$contenuto}', '{$path}', NOW(), {$materia}, {$id}, {$categoria}, '{$visibilita}')";
               $result = $connection->query($sql);
                if($result) {
                     echo 'File caricato con successo';
                }
                else {
                     echo 'Errore nel caricamento del file';
                }
            } 
            
        }  
    }
    else{
        echo 'Accesso negato';
    }
