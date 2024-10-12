<?php

include('navbar.php');

if(isset($_REQUEST["remove"])) 
    session_unset();

if(isset($_SESSION["restoreDataSignup"])) {
    $previousData = $_SESSION["restoreDataSignup"];

    $username = $previousData["usernameSignup"];
    $name = $previousData["nameSignup"];
    $surname = $previousData["surnameSignup"];
    $email = $previousData["emailSignup"];
}
else {
    $username = "";
    $name = "";
    $surname = "";
    $email = "";
}

assignErrors("", $errorUsername);
assignErrors("", $errorName);
assignErrors("", $errorSurname);
assignErrors("", $errorEmail);
assignErrors("", $errorPassword);
assignErrors("", $notIdentical);

if(isset($_SESSION["errors"])) {
    $errors = $_SESSION["errors"];

    if(isset($errors["errorUsername"]))
        assignErrors($errors["errorUsername"], $errorUsername);

    if(isset($errors["errorName"]))
        assignErrors($errors["errorName"], $errorName);

    if(isset($errors["errorSurname"]))
        assignErrors($errors["errorSurname"], $errorSurname);

    if(isset($errors["errorEmail"]))
        assignErrors($errors["errorEmail"], $errorEmail);

    if(isset($errors["errorPassword"])) 
        assignErrors($errors["errorPassword"], $errorPassword);

    if(isset($errors["notIdentical"])) 
        assignErrors($errors["notIdentical"], $notIdentical);
    
}

function assignErrors($message, &$variable) {
    $variable = $message;
}

echo $pageStarter;
?>

    <title>Sign up</title>
    <div style="min-width: 30%; max-width: 70%; margin: auto;" class="text-light border border-3 rounded rounded-5 border-primary p-4 mt-4">
        <div class="header">
        <svg style="font-size: 30px; display: inline-block; position: relative; bottom: 5px;" xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" class="bi bi-person-fill-up" viewBox="0 0 16 16">
            <path d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7m.354-5.854 1.5 1.5a.5.5 0 0 1-.708.708L13 11.707V14.5a.5.5 0 0 1-1 0v-2.793l-.646.647a.5.5 0 0 1-.708-.708l1.5-1.5a.5.5 0 0 1 .708 0M11 5a3 3 0 1 1-6 0 3 3 0 0 1 6 0"/>
            <path d="M2 13c0 1 1 1 1 1h5.256A4.5 4.5 0 0 1 8 12.5a4.5 4.5 0 0 1 1.544-3.393Q8.844 9.002 8 9c-5 0-6 3-6 4"/>
        </svg>
        <h3 class="centered" style="display: inline-block;" class="login-title">Sign up</h3>
        </div>
        <div class="body">

            <span style="color: red;">
                <p style="text-align: center;"><?php echo $notIdentical; ?></p>
            </span>

            <form action="../utilities/check.php" method="post">
                <div class="form-group">
                    <label class="labelSignup" for="name">Username:</label>
                    <input type="text" style="color: black;" class="form-control" id="username" name="username" value="<?php echo $username ?>">
                    <span style="color: red"><?php echo $errorUsername ?></span>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col">
                            <label class="labelSignup" for="name">Name:</label>
                            <input type="text" style="color: black;" class="form-control" id="name" name="name" value="<?php echo $name ?>">
                            <span style="color: red"><?php echo $errorName ?></span>
                        </div>
                        <div class="col">
                            <label class="labelSignup" for="surname">Surname:</label>
                            <input type="text" style="color: black;" class="form-control" id="surname" name="surname" value="<?php echo $surname ?>">
                            <span style="color: red"><?php echo $errorSurname ?></span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="labelSignup" for="email">Email:</label>
                    <input type="email" style="color: black;" class="form-control" id="email" name="email" value="<?php echo $email ?>" placeholder="yourmail@example.com">
                    <span style="color: red"><?php echo $errorEmail ?></span>
                </div>
                <div class="form-group">
                    <label class="labelSignup" for="password">Password:</label>
                    <div class="input-group mb-3">
                        <input type="password" class="form-control" id="password" style="position: relative; z-index: 0; color: black;" name="password" aria-describedby="basic-addon2">
                        <?php include "../utilities/passwordTooltip.php"; ?>
                        <span class="input-group-text" id="basic-addon2">
                            <i class="bi bi-eye-slash" id="togglePassword1"></i>
                        </span>
                    </div>
                    <span style="color: red;"><?php echo $errorPassword; ?></span>
                </div>
                <div class="form-group">
                    <label class="labelSignup" for="password">Confirm password:</label>
                    <div class="input-group mb-3">
                        <input type="password" style="color: black;" class="form-control" id="confermapassword" name="confermapassword" aria-describedby="basic-addon2">
                        <span class="input-group-text" id="basic-addon2" >
                            <i class="bi bi-eye-slash" id="togglePassword2"></i>
                        </span>
                    </div>
                </div>
                <button type="submit" name="signup" class="btn btn-primary mt-1" value="Invia">Send</button>
                <!-- BEGIN: ed8c6549bwf9 -->
                <br>
                <br>
                <p class="mb-0">Already have an account? <a class="text-decoration-none" href="login.php?remove=true">Please log in</a></p>
                <!-- END: ed8c6549bwf9 -->
                
            </form>
        </div>
    </div>

    <script>
        const togglePassword = document
            .querySelector("#togglePassword1");
        const password = document.querySelector("#password");
        togglePassword.addEventListener("click", () => {
            // Toggle the type attribute using
            // getAttribure() method
            const type = password
                .getAttribute("type") === "password" ?
                "text" : "password";
            password.setAttribute("type", type);
        
            // Toggle the eye and bi-eye icon
            togglePassword.classList.toggle("bi-eye");
        });
        const toggleConfermaPassword = document
            .querySelector("#togglePassword2");
        const confermapassword = document.querySelector("#confermapassword");
        toggleConfermaPassword.addEventListener("click", () => {
            // Toggle the type attribute using
            // getAttribure() method
            const type = confermapassword
                .getAttribute("type") === "password" ?
                "text" : "password";
            
                confermapassword.setAttribute("type", type);
            // Toggle the eye and bi-eye icon
            toggleConfermaPassword.classList.toggle("bi-eye");
        });
    </script>

    <style>
        .labelSignup {
            margin-left: 7px;
        }
    </style>

</body>
</html>