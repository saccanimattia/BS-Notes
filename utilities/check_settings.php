<?php

include("connection.php");

session_start();
$userId = $_SESSION["id"];
$page = "../routes/settings.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve data received in POST
    $username = $_POST['username'];
    $nome = $_POST['name'];
    $cognome = $_POST['surname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confermapassword = $_POST['confermapassword'];

    
}

$_SESSION["errors"] = array(
    "errorUsername" => "",
    "errorName" => "",
    "errorSurname" => "",
    "errorEmail" => "",
    "errorPassword" => "",
    "notIdentical" => ""
);

// Retrieve user data from the database with the given user id
$query = "SELECT * FROM utente WHERE id = $userId";
$result = mysqli_query($connection, $query);
$userData = mysqli_fetch_assoc($result);

$unmodifiedUsername = $userData["username"];
$unmodifiedName = $userData["nome"];
$unmodifiedSurname = $userData["cognome"];
$unmodifiedEmail = $userData["email"];
$unmodifiedPassword = $userData["userPassword"];

if(strlen($username) < 3) {
    $username = $unmodifiedUsername;

    
 }
 if(strlen($nome) == 0) {
        $nome = $unmodifiedName;
        
 }
 if(strlen($cognome) == 0) {
        $cognome = $unmodifiedSurname;
        
 }
 if(strlen($email) == 0 || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $email = $unmodifiedEmail;
     
 }
 //Controlli password sicura (min 8 char, maiuscola, minuscola, almeno un numero, almeno un carattere speciale)
 if(strlen($password) < 8) {
     $password = $unmodifiedPassword;
     
 }
 else if(strlen($confermapassword) < 8) {
        $password = $unmodifiedPassword;
       
 }
 else {
        if(strcmp($password, $confermapassword) != 0){
            $password = $unmodifiedPassword;
          
        }
            
        else{
            if(!validatePassword(str_split($password))) {
                $password = $unmodifiedPassword;
            }
                
        }
    }

    $connection->query("update utente set username = '$username', nome = '$nome', cognome = '$cognome', email = '$email', userPassword = '$password' where id = '$userId'");
    header("Location: $page");
    exit();

    function validatePassword($password) {

        $numbers = "0123456789";
        $lowerChars = "abcdefghijklmnopqrstuvwxyz";
        $specialChars = "!?@#+*";
    
        $numberFound = false;
        $lowerCharFound = false;
        $upperCharFound = false;
        $specialCharFound = false;
    
        foreach($password as $char) {
            if(is_numeric($char))
                $numberFound = true;
            if(compare($char, str_split($lowerChars)))
                $lowerCharFound = true;
            if(compare($char, str_split(strtoupper($lowerChars))))
                $upperCharFound = true;
            if(compare($char, str_split($specialChars)))
                $specialCharFound = true;
            if($numberFound && $lowerCharFound && $upperCharFound && $specialCharFound)
                return true;
        }
        return false;
    }

    

function compare($x, $array) {
    foreach($array as $char) {
        if(strcmp($x, $char) == 0)
            return true;
    }
    return false;
}

 
        ?>
