<?php

include('connection.php');

session_start();

if(isset($_SESSION["id"]) && isset($_POST["friendId"])) {
    $userId = $_SESSION["id"];
    $friendId = $_POST["friendId"];
    $route = $_POST["route"];

    $query = "DELETE FROM amicizia WHERE (id_utente1 = $userId AND id_utente2 = $friendId) OR (id_utente1 = $friendId AND id_utente2 = $userId)";
    $result = $connection->query($query);

    if($result) {
        if(isset($_POST["postId"])) {
            $postId = $_POST["postId"];
            header("Location: $route" . "?id=" . $postId);
        } else {
            header("Location: $route");
        }
    } 
} else {
    echo '
        <!DOCTYPE html>
        <html>
        <head>
            <title>Accesso Negato</title>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    background-color: #f2f2f2;
                }

                .container {
                    max-width: 400px;
                    margin: 0 auto;
                    margin-top: 7%;
                    height: 50%;
                    padding: 20px;
                    background-color: #fff;
                    border-radius: 5px;
                    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
                    text-align: center;
                }

                h1 {
                    color: #ff0000;
                }

                p {
                    margin-bottom: 20px;
                }

            </style>
        </head>
        <body>
            <div class="container">
                <h1 class="display-4">Accesso Negato</h1>
                <p class="lead">Per accedere a questo servizio è necessario effettuare il login.</p>
            </div>
        </body>
        </html>
    ';
}
