<?php

include('navbar.php');

if(isset($_REQUEST["remove"])) {
    session_unset();
}
    
if(isset($_SESSION["notFound"])) {
    $username = $_SESSION["username"];
    $errorLogin = "Username or email not found, try to <a href='signup.php'>sign up</a> instead";
}
else if(isset($_SESSION["wrongPassword"])) {
    $username = $_SESSION["username"];
    $errorLogin = "Username or password wrong";
}
else if(isset($_SESSION["emptyPassword"])) {
    $username = $_SESSION["username"];
    $errorLogin = "Type in you password first!";
}
else if(isset($_SESSION["emptyForm"])) {
    $username = "";
    $errorLogin = "Fill in the form below to log in!";
}
else {
    $username = "";
    $errorLogin = "";
}
echo $pageStarter;

?>
    <title>Login</title>
    <div style="min-width: 30%; max-width: 60%; margin: auto;" class="text-light border border-3 rounded rounded-5 border-primary p-4 mt-4">
        <div class="login-header" >
            <i style="display: inline-block; font-size: 30px;" class="bi bi-people-fill" width="1em" height="1em"></i>
            <h3 class="centered" style="display: inline-block;" class="login-title">Login</h3>
        </div>
        <div>
            <span style="color: red;">
                <p style="text-align: center;"><?php echo $errorLogin; ?></p>
            </span>
            <form action="../utilities/check.php" method="post">
                
                <div class="form-group">
                    <label class="ml-2" for="username">Username or email:</label>
                    <input type="text" class="form-control" style="color: black;" id="username" name="username" value="<?php echo $username; ?>">
                </div>
                <div class="form-group">
                    <label class="ml-2" for="password">Password:</label>
                    <div class="input-group mb-3">
                        <input type="password" style="color: black;" class="form-control" style="position: relative; z-index: 0;"  id="password" name="password" aria-describedby="basic-addon2">
                        <span class="input-group-text" id="basic-addon2">
                            <i class="bi bi-eye-slash" id="togglePassword1"></i>
                        </span>
                    </div>
                </div>
                <button type="submit" name="login" class="btn btn-primary mt-1" value="Invia">Send</button>
                <br>
                <br>
                <p class="mb-0">Don't have an account? <a class="text-decoration-none" href="signup.php?remove=true">Sign up instead</a></p>
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
    </script>
    
</body>
</html>