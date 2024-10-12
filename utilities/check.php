<?php

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $previousPage = $_SERVER["HTTP_REFERER"];

    $homepage = "../routes/homepage.php";

    include 'connection.php';

    if(isset($_POST["login"])) {
        $username = $_POST["username"];
        $password = $_POST["password"];

        session_destroy();
        session_start();
        $_SESSION["username"] = $username;

        if(strlen($username) == 0) {
            $_SESSION["emptyForm"] = true;
            header("Location: $previousPage");
            exit();
        }
        else if(strlen($password) == 0) {
            $_SESSION["emptyPassword"] = true;
            header("Location: $previousPage");
            exit();
        }
        $user = $connection->query("select * from utente where username = '$username' or email = '$username'");
        
        if($user->num_rows > 0) {
            while($row = $user->fetch_assoc()) {
                if(strcmp($password, $row["userPassword"]) == 0) {
                    session_unset();
                    session_destroy();
                    session_start();
                    $_SESSION["id"] = $row["id"];
                    header("HTTP/1.1 200 OK");
                    header("Location: ../routes/homepage.php");
                    exit();
                }
                else {
                    $_SESSION["wrongPassword"] = true;
                    header("HTTP/1.1 403 Forbidden");
                    header("Location: $previousPage");
                    exit();
                }
            }
        }
        else {
            $_SESSION["notFound"] = true;
            header("HTTP/1.1 401 Unauthorized");
            header("Location: $previousPage");
            exit();
        }
    }
    else if(isset($_POST["signup"])) {
        $username = $_POST["username"];
        $nome = $_POST["name"];
        $cognome = $_POST["surname"];
        $email = $_POST["email"];
        $password = $_POST["password"];
        $confermapassword = $_POST["confermapassword"];

        session_start();

        $_SESSION["errors"] = array(
            "errorUsername" => "",
            "errorName" => "",
            "errorSurname" => "",
            "errorEmail" => "",
            "errorPassword" => "",
            "notIdentical" => ""
        );

        if(strlen($username) < 3) {
           $_SESSION["errors"]["errorUsername"] = "The username must contain at least 3 characters";
        }
        if(strlen($nome) == 0) {
            $_SESSION["errors"]["errorName"] = "The name is mandatory";
        }
        if(strlen($cognome) == 0) {
            $_SESSION["errors"]["errorSurname"] = "The surname is mandatory";
        }
        if(strlen($email) == 0 || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION["errors"]["errorEmail"] = "The e-mail provided is not valid";
        }
        //Controlli password sicura (min 8 char, maiuscola, minuscola, almeno un numero, almeno un carattere speciale)
        if(strlen($password) < 8) {
            $_SESSION["errors"]["errorPassword"] = "The password is too short (minimum 8 characters)";
        }
        else if(strlen($confermapassword) < 8) {
            $_SESSION["errors"]["errorPassword"] = "Confirm your password to continue";
        }
        else {
            if(strcmp($password, $confermapassword) != 0)
                $_SESSION["errors"]["notIdentical"] = "Passwords does not match";
            else {
                if(!validatePassword(str_split($password))) 
                    $_SESSION["errors"]["errorPassword"] = "The password does not satisfy the requirements";
            }
        }

        if(checkErrors($_SESSION["errors"])) {
            $user = $connection->query("select * from utente where username = '$username' or email = '$email'");
            if($user->num_rows > 0) {
                $_SESSION["errors"]["notIdentical"] = "This email seems to be already registered, try to log in";
                header("Location: $previousPage");
                exit();
            }
            else {
                $connection->query("insert into utente (username, nome, cognome, email, userPassword) values ('$username', '$nome', '$cognome', '$email', '$password')");
                $user = $connection->query("select * from utente where username = '$username'");
                while($x = $user->fetch_assoc()) {
                    session_unset();
                    session_destroy();
                    session_start();
                    $_SESSION["id"] = $x["id"];
                    header("Location: ../routes/avatarChooser.php");
                    exit();
                }
            }
            
        }
        else {
            $_SESSION["restoreDataSignup"] = array(
                "usernameSignup" => $username, 
                "nameSignup" => $nome, 
                "surnameSignup" => $cognome, 
                "emailSignup" => $email
            );
            header("Location: $previousPage");
            exit();
        }

    }
}
session_unset();
session_destroy();
header("Location: ../settings/login.php");

function checkErrors($array) {
    foreach($array as $x => $value) {
        if(strcmp($value, "") != 0)
            return false;
    }
    return true;
}

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