
const divHome = document.querySelector('#homeDiv');
const divDashboard = document.querySelector('#dashboardDiv');
const divGrid = document.querySelector('#gridDiv');
var file = [];

document.querySelector('#homeLink').addEventListener('click', function() {
    visualizzaPagina("block", "none", "none");
    inserisciClassi("attivo", "text-primary", "text-primary");
});
document.querySelector('#dashboardLink').addEventListener('click', function() {
    visualizzaPagina("none", "block", "none");
    inserisciClassi("text-primary", "attivo", "text-primary");
});
document.querySelector('#gridLink').addEventListener('click', function() {
    visualizzaPagina("none", "none", "block");
    inserisciClassi("text-primary", "text-primary", "attivo");
});

document.querySelector('.btn-primary').addEventListener('click', function() {
    $('#myModal').modal('show');
});
const togglePassword = document
    .querySelector('#togglePassword1');
const password = document.querySelector('#password');
togglePassword.addEventListener('click', () => {
    // Toggle the type attribute using
    // getAttribure() method
    const type = password
        .getAttribute('type') === 'password' ?
        'text' : 'password';
    password.setAttribute('type', type);
    // Toggle the eye and bi-eye icon
    togglePassword.classList.toggle('bi-eye');
});
const toggleConfermaPassword = document
    .querySelector('#togglePassword2');
const confermapassword = document.querySelector('#confermapassword');
toggleConfermaPassword.addEventListener('click', () => {
    // Toggle the type attribute using
    // getAttribure() method
    const type = password
        .getAttribute('type') === 'password' ?
        'text' : 'password';
    password.setAttribute('type', type);
    // Toggle the eye and bi-eye icon
    toggleConfermaPassword.classList.toggle('bi-eye');
});

visualizzaPagina = (v1, v2, v3) =>{
    divHome.style.display = v1;
    divDashboard.style.display = v2;
    divGrid.style.display = v3;
}

inserisciClassi = (v1, v2, v3) => {
    const homeLink = document.querySelector('#homeLink');
    const dashboardLink = document.querySelector('#dashboardLink');
    const gridLink = document.querySelector('#gridLink');

    togliClasseAttivo(homeLink);
    togliClasseAttivo(dashboardLink);
    togliClasseAttivo(gridLink);

    togliClasseNonAttivo(homeLink);
    togliClasseNonAttivo(dashboardLink);
    togliClasseNonAttivo(gridLink);

    if (v1 === 'attivo') {
        homeLink.classList.add('active');
    }
    if (v2 === 'attivo') {
        dashboardLink.classList.add('active');
    }
    if (v3 === 'attivo') {
        gridLink.classList.add('active');
    }

    homeLink.classList.add(v1);
    dashboardLink.classList.add(v2);
    gridLink.classList.add(v3);
}

togliClasseAttivo = (elemento) => {
    if (elemento.classList.contains('active')) {
        elemento.classList.remove('active');
        elemento.classList.remove('attivo');
    }
}

togliClasseNonAttivo = (elemento) => {
    if (elemento.classList.contains('text-primary')) {
        elemento.classList.remove('text-primary');
    }
}


function handleDragOver(event) {
    event.preventDefault();
    event.dataTransfer.dropEffect = "copy";
}

function handleDrop(event) {
    event.preventDefault();
    inserisciFile(event.dataTransfer.files[0])
    
}


function handleFileChange(event) {
    console.log("file caricato");
    inserisciFile(event.target.files[0]);
}

function inserisciFile(fileCaricato) {
    file.push(fileCaricato);
    console.log(fileCaricato);
    const fileName = fileCaricato.name;
    const fileDiv = document.createElement('div');
    fileDiv.classList.add('fileSelezionati');
    fileDiv.style.display = 'flex'; // Add flexbox display
    const deleteIcon = document.createElement('i'); // Create an i element for the delete icon
    deleteIcon.classList.add('bi', 'bi-trash');
    deleteIcon.textContent = fileName; // Set the file name as the content of the delete icon
    deleteIcon.addEventListener('click', function() {
        rimuoviFile(fileName);
    }); // Add the Bootstrap Icons classes
    fileDiv.appendChild(deleteIcon);
    

    

    document.querySelector('#fileCaricati').appendChild(fileDiv);
}

rimuoviFile = (fileName) => {
    const confirmDelete = confirm(`Are you sure you want to delete the file "${fileName}"?`);
    if (confirmDelete) {
        // Remove file from the array
        file = file.filter(fileItem => fileItem.name !== fileName);

        // Remove the corresponding div
        const fileDiv = document.querySelector('.fileSelezionati');
        if (fileDiv) {
            fileDiv.remove();
        }
    }
}

$(function() {

    const federalHolidays = [
        
    ];

    $("#calendar").dxCalendar({
        showTodayButton: true,
        showWeekNumbers: false,
        hint: "Click to add a note on this date",

     });
     
    
     

});



//Login e Signup

/*<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
    
        <div class="modal-content text-dark">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Sign up</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" >
                <form method="post" action="check.php">
                    <div class="form-group">
                        <label for="name">Username:</label>
                        <input type="text" class="form-control" id="username" name="username" value="<?php echo $usernameSignup; ?>">
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col">
                                <label for="name">Nome:</label>
                                <input type="text" class="form-control" id="name" name="name" value="<?php echo $nameSignup; ?>">
                            </div>
                            <div class="col">
                                <label for="surname">Cognome:</label>
                                <input type="text" class="form-control" id="surname" name="surname" value="<?php echo $surnameSignup; ?>">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?php echo $emailSignup; ?>">
                    </div>
                    <div class="form-group">
                        <label for="password">Password:</label>
                        <div class="input-group mb-3">
                            <input type="password" class="form-control" id="password" name="password" aria-describedby="basic-addon2">
                            <span class="input-group-text" id="basic-addon2">
                                <i class="bi bi-eye-slash" id="togglePassword1"></i>
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="password">Conferma password:</label>
                        <div class="input-group mb-3">
                            <input type="password" class="form-control" id="confermapassword" name="confermapassword" aria-describedby="basic-addon2">
                            <span class="input-group-text" id="basic-addon2" >
                                <i class="bi bi-eye-slash" id="togglePassword2"></i>
                            </span>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary" name="signup">Invia</button>
                    <!-- BEGIN: ed8c6549bwf9 -->
                    <br>
                    <br>
                    <a href="#" data-toggle="modal" data-target="#modalSignUp" data-dismiss="modal">Se sei già registrato, clicca qui</a>
                    <!-- END: ed8c6549bwf9 -->
                    
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalSignUp" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
    
        <div class="modal-content text-dark">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Login</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" >
                <form method="post" action="check.php">
                    <span style="color: red;"><?php echo $errLogin; ?></span><br>
                    <div class="form-group">
                        <label for="name">Username o email:</label>
                        <input type="text" class="form-control" id="username" name="username" value="<?php echo $usernameLogin; ?>">
                    </div>
                    <div class="form-group">
                        <label for="password">Password:</label>
                        <div class="input-group mb-3">
                            <input type="password" class="form-control" id="password" name="password" aria-describedby="basic-addon2">
                            <span class="input-group-text" id="basic-addon2">
                                <i class="bi bi-eye-slash" id="togglePassword1"></i>
                            </span>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary" name="login">Invia</button>
                    <br>
                    <br>
                    <a href="#" data-toggle="modal" data-target="#myModal" data-dismiss="modal">Se non sei ancora registrato, clicca qui</a>
                </form>
            </div>
        </div>
    </div>
</div>*/




