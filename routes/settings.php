<?php
    include('navbar.php');
    echo $pageStarter;

    if(isset($_SESSION["id"])) {
        include('../utilities/connection.php');
        $userId = $_SESSION["id"];

        include "personalInfos.php";
        include "chooseAvatar.php";

        if(isset($_REQUEST["avatar"])) {
            $infosVisiblity = "none";
            $avatarsVisibility = "block";
            $selection = "#chooseAvatar";
        }
        else {
            $infosVisiblity = "block";
            $avatarsVisibility = "none";
            $selection = "#personalInfo";
        }
        echo "
        <style>
            #infosDiv{
                display: $infosVisiblity;
                margin-top: 30px;
            }
            #avatarsDiv {
                display: $avatarsVisibility;
            }
            $selection {
                border: 1px solid deepskyblue;
            }
        </style>
        ";
    }
    else {
        include "../utilities/redirect.php";
        redirect("login_required.php");
    }
?>

    <title>Settings</title>
    <div id="major_container">
        <div id="menu">
            <button type="button" class="btn menuBut" id='personalInfo'>Personal Information</button>
            <br><br>
            <button type="button" class="btn menuBut" id='chooseAvatar'>Avatar</button>
        </div>
        <div id="content">
            <div class="childContents" id="infosDiv">
                <?php echo $changePersonalInfos; ?>
            </div>
            <div class="childContents" id="avatarsDiv">
                <?php echo $containerAvatars; ?>
            </div>
        </div>
    </div>

    <style>
        #menu {
            background-color: #19232e;
            float: left;
            width: 21%;
            text-align: center;
            height: 644px;
            padding-top: 20px;
            padding-bottom: 10px;
        }
        .menuBut {
            background-color: transparent;
            color: azure;
            font-weight: bold;
        }
        .menuBut:hover {
            color: deepskyblue;
        }
        #content {
            float: left;
            width: 77%;
            background-color: inherit;
        }
    </style>

    <script>
        const divs = document.getElementsByClassName("childContents")
        const buttons = document.getElementsByClassName("menuBut")

        const personalInfoHeight = screen.height
        const avatarHeight = "1233px"

        window.onload = function() {
            document.getElementById("personalInfo").addEventListener("click", displayDivs)
            document.getElementById("chooseAvatar").addEventListener("click", displayDivs)
        }
        function displayDivs(e) {
            let param1 = ""
            let param2 = ""
            let border1 = ""
            let border2 = ""

            const borderStyle = "1px solid deepskyblue"

            let height = ""

            if(e.target.id == "personalInfo") {
                param1 += "block"
                param2 += "none"

                border1 += borderStyle
                border2 += "none"

                height += personalInfoHeight
            }
            else if(e.target.id == "chooseAvatar") {
                param1 += "none"
                param2 += "block"

                border1 += "none"
                border2 += borderStyle

                height += avatarHeight
            }
            divs[0].setAttribute("style", "display: " + param1)
            divs[1].setAttribute("style", "display: " + param2)

            buttons[0].setAttribute("style", "border: " + border1)
            buttons[1].setAttribute("style", "border: " + border2)

            document.getElementById("menu").setAttribute("style", "height: " + height)
        }
    </script>

<?php
    include('finepagina.php');
?>