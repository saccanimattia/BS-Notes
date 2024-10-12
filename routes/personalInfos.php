<?php

    $sql = "
        select *
        from utente u
        where u.id = '$userId';
    ";
    $data = $connection->query($sql)->fetch_all(MYSQLI_ASSOC)[0];

    $name = $data['nome'];
    $surname = $data['cognome'];
    $username = $data['username'];
    $email = $data['email'];

    $changePersonalInfos = '
        <div class="container-fluid text-light border border-3 rounded rounded-5 border-primary p-4 mt-4" style="max-width: 70%;">
            <div class="text-start login-header mb-3" >
                <i style="display: inline-block; font-size: 30px;" class="bi bi-gear-fill" width="1em" height="1em"></i>
                <h3 class="centered ml-1" style="display: inline-block;" class="login-title">Change your personal information</h3>
            </div>
            <form action="../utilities/check_settings.php" method="post">
                <div class="form-group">
                    <label for="name">Username:</label>
                    <input type="text" class="form-control" id="username" name="username" value="' .$username .'">
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col">
                            <label for="name">Name:</label>
                            <input type="text" class="form-control" id="name" name="name" value="' .$name .'">
                        </div>
                        <div class="col">
                            <label for="surname">Surname:</label>
                            <input type="text" class="form-control text-black" id="surname" name="surname" value="' .$surname .'">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" class="form-control text-black" id="email" name="email" value="'. $email .'" placeholder="yourmail@example.com">
                </div>
                <div class="form-group">
                    <label for="password">Reset Password:</label>
                    <div class="input-group mb-3">
                        <input type="password" class="form-control text-black" id="password" style="position: relative; z-index: 0;" name="password" aria-describedby="basic-addon2">
                        <?php include "../utilities/passwordTooltip.php"; ?>
                        <span class="input-group-text" id="basic-addon2">
                            <i class="bi bi-eye-slash" id="togglePassword1"></i>
                        </span>
                    </div>
                </div>
                <div class="form-group">
                    <label for="password">Confirm new password:</label>
                    <div class="input-group mb-3">
                        <input type="password" class="form-control text-black" id="confermapassword" name="confermapassword" aria-describedby="basic-addon2" onchange="controllo()">
                        <span class="input-group-text" id="basic-addon2">
                            <i class="bi bi-eye-slash" id="togglePassword2"></i>
                        </span>
                    </div>
                </div>
                <button type="submit" name="signup" class="btn btn-primary" value="Invia">Send</button>
            </form>
        </div>
    </body>

    <script>
        const togglePassword = document.querySelector("#togglePassword1");
        const password = document.querySelector("#password");

        togglePassword.addEventListener("click", () => {
            const type = password.getAttribute("type") === "password" ? "text" : "password";
            password.setAttribute("type", type);
            togglePassword.classList.toggle("bi-eye");
        });
    </script>
    ';