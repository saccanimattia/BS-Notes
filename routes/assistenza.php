<?php

include('navbar.php');
include('../utilities/connection.php');
include "../utilities/redirect.php";

$error_selection = "";
if(isset($_SESSION["id"])) {

    $sql = "SELECT email FROM utente WHERE id = " .$_SESSION["id"];
    $result = $connection->query($sql);
    $row = mysqli_fetch_assoc($result);
    $email = $row["email"];

    $assistance_options = $connection->query("select id, categoria from assistenza_categorie")->fetch_all(MYSQLI_ASSOC);
    $assistance_options_html = "";
    foreach($assistance_options as $option) {
        $assistance_options_html .= 
        "<option value='" .$option["id"] ."'>" .$option["categoria"] ."</option>";
    }
}
else {
    redirect("login_required.php");
}

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $isOk = true;
    if($_POST["assistance_category"] == "-1") {
        $error_selection = "You must select an option";
        $isOk = false;
    }
    if($_POST["problem"] == "") {
        $isOk = false;
    }

    if($isOk) {
        $sql = 'insert into assistenza(description, fk_id_categoria, fk_id_utente) values
        ("' .$_POST["problem"] .'", ' .$_POST["assistance_category"] .', ' .$_SESSION["id"] .');';
        if ($connection->query($sql)) {
            redirect("../utilities/risultato_richiesta.php?res=true");
        }
        else {
            redirect("../utilities/risultato_richiesta.php?res=false");
        }
    }
}

echo $pageStarter;

?>

<title>Assistenza</title>
<div >
    <div class="login-container text-light border border-3 rounded rounded-5 border-primary p-4 mt-4" style="min-width: 30%; max-width: 60%; margin: auto;">
    <div class="header">
    <i style="display: inline-block; font-size: 22px;" class="bi bi-chat-left-text-fill mr-2" width="1em" height="1em" ></i>
    <h3 style="display: inline-block;" class="login-title">Contact us</h3>
    <br>
    </div>
        <div class="body" >
            <form method="POST">
                <div class="form-group">
                    <label class="ml-2" for="email">Email:</label>
                    <input type="email" class="form-control" style="color: black;" readonly="readonly" id="email" name="email" value="<?php echo $email; ?>">
                </div>
                <label class="ml-2" for="assistance_category">What's your issue?</label><br>
                <select class="select" name="assistance_category">
                    <option selected value="-1">Choose the category of your problem</option>
                    <?php echo $assistance_options_html; ?>
                </select>
                <p class="d-inline-block text-danger ml-3"><?php echo $error_selection; ?></p>
                <div class="form-group">
                    <label class="ml-2" for="problem">Describe your problem here:</label><br>
                    <textarea class="form-control text-black" name="problem" id="problem" style="min-height: 80px; max-height: 200px; color: black;" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary mt-1">Submit</button>
            </form>
        </div>
    </div>
</div>

<style>
    .select {
        border-radius: 8px;
        height: 40px;
        width: 50%;
        background-color: transparent;
        color: white;
        border: 1px solid #0077ff;
        text-align: left;
        padding-left: 6px;
        margin-bottom: 15px;
    }
    .select option {
        font-size: 14px; 
        padding: 30px; 
        background-color: #212529;; 
        color: white; 
    }
    .select::-ms-expand {
        background-color: black;
    }
</style>