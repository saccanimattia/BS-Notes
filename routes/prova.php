<?php
    define('MYSQL_USER', 'root');
    define('PASSWORD', '');
    define('HOST', 'localhost');
    define('DATABASE', 'users');


    $dsn='mysql:host='.HOST.';dbname='.DATABASE; 
    
    try{
        $objPDO= new PDO ($dsn, MYSQL_USER, PASSWORD);
        echo "connessione avvenuta con successo \n";
    }catch(PDOException $e){
        echo 'errore nella connessione: '.$e->getMessage();
    }
    //chiude la connessione
    //$objPDO=NULL;

    try{
        $sql='SELECT * FROM usersprofiles';
        $objstm= $objPDO->query($sql);
        
        $dati=array();
        $dati=$objStm->fetchAll();
        
    }catch(PDOException $e){
        echo 'error: '.$e->geteMessage();
        echo 'line' .$e->getLine();
        echo 'file' .$e->getFile();
    }

?>