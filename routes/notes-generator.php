<?php

include('navbar.php');
include "../utilities/redirect.php";
echo $pageStarter;

if(isset($_SESSION["id"])) {
    if($_SERVER["REQUEST_METHOD"] == "GET") {
        $page = htmlspecialchars($_SERVER['PHP_SELF']);
        include "../utilities/selectionFiller.php";
        $languages = populateLanguages();
        $subjects = populateSubjects();
    }
}
else {
    redirect("login_required.php");
}

?>

<title>Notes Generator</title>

<div class="cover">
    <div class="z-2 loader-container">
        <div id="loader"></div>
        <div class="mt-4 text-light text-center">
            <p id="three_points">Wait while we process your request.</p>
        </div>
    </div>
</div>

<div id="dashboardDiv" class="mt-3 z-0">
    <div class="mb-2" style=" padding-bottom:1%;text-align: center; font-size: 50px; color:#0077ff">
        <i class="bi-file-text" ></i>
        <strong>Notes Generator</strong> 
    </div>
    <form id="myForm">
        <div class="text-light border border-3 rounded rounded-5 border-primary p-4" style="width: 90%; margin: auto; height: fit-content;">
            <div class="mb-0" style="margin: auto; width: fit-content;">
                <div class="form-check d-inline-block borderHover">
                    <input class="d-inline-block inputType inputs" type="radio" checked name="inputType" value="text" id="text">
                    <label class="form-check-label labelInput" for="text">
                        Write a text
                    </label>
                </div>
                <div class="form-check d-inline-block borderHover"  style="margin-left: 300px;">
                    <input class="inputType inputs" type="radio" name="inputType" value="audio" id="audio">
                    <label class="form-check-label labelInput" for="audio">
                        Audio file
                    </label>
                </div>
            </div>
        
            <div class="form-group mt-5 text-light text-center">
                <div style="width: fit-content; margin: auto;">
                    <div class="d-inline-block" id='noteType'>
                        <h3>Choose what type the note should be:</h3>
                        <div class="form-check borderHover d-inline-block">
                            <input class="form-check-input inputs" type="radio" name="noteType" value="summary" id="summary" checked>
                            <label class="form-check-label labelInput" for="summary">
                                Summary
                            </label>
                        </div>
                        <div class="form-check borderHover d-inline-block">
                            <input class="form-check-input inputs pl-1" type="radio" name="noteType" value="conceptualMap" id="conceptualMap">
                            <label class="form-check-label labelInput" for="conceptualMap">
                                Conceptual map
                            </label>
                        </div>
                    </div>
                    <div class="d-inline-block" id="accuracyLevel">
                        <h3>Choose how much details:</h3>
                        <div class="form-check borderHover d-inline-block">
                            <input class="form-check-input inputs" type="radio" name="accuracy" value="very_detailed" id="very_detailed" checked>
                            <label class="form-check-label labelInput" for="very_detailed">
                                Very detailed
                            </label>
                        </div>
                        <div class="form-check borderHover d-inline-block">
                            <input class="form-check-input inputs pl-1" type="radio" name="accuracy" value="detailed" id="detailed">
                            <label class="form-check-label labelInput" for="detailed">
                                Detailed
                            </label>
                        </div>
                        <div class="form-check borderHover d-inline-block">
                            <input class="form-check-input inputs pl-1" type="radio" name="accuracy" value="essential" id="essential">
                            <label class="form-check-label labelInput" for="essential">
                                Essential
                            </label>
                        </div>
                    </div>
                </div>
                <div class="mt-5 form-group d-inline-block pl-5" style='width: 49%;'>
                    <h3>Choose the language:</h3>
                    <select class="mt-2 select" name='language'>
                        <?php echo $languages; ?>
                    </select>
                </div>
                <div class="mt-5 form-group d-inline-block" style='width: 50%;'>
                    <h3>Choose who can see your note:</h3>
                    <select class="mt-2 select" name='isPublic'>
                        <option value='pubblico' selected>Anyone</option>
                        <option value='solo_amici'>Only my friends</option>
                        <option value='privato'>Nobody</option>
                    </select>
                </div>
                <div class="mt-5 form-group d-inline-block" style='width: 50%;'>
                    <h3>Choose what subject the note is:</h3>
                    <select class="mt-2 select" name='subject'>
                        <?php echo $subjects; ?>
                    </select>
                </div>
                <div style="width: 100%; position: relative; bottom: 10px;">
                    <div class="mb-2" id="textInput">
                        <h3 class="mb-4 mt-5">Type your text:</h3>
                        <textarea class="form-control" id="textInput" name="text" maxlength="5000" style=" margin: auto; min-height: 100px; max-height: 250px; min-width: 70%; max-width: 70%; color: black;"></textarea>
                    </div>
                    <div class="mb-0 mt-5" id="audioInput" style="display: none;">
                        <div style="width: 100%; margin: auto;">
                            <div class="form-group">
                                <h3 class="mb-3 mt-5">Click the microphone to record your voice:</h3>
                                <i id="audio_recorder" class="bi bi-mic"></i>
                                <textarea class="form-control" id="speech_to_text" name="audio_text" maxlength="5000" style=" margin: auto; min-height: 100px; max-height: 250px; min-width: 70%; max-width: 70%; color: black;"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="pt-4" style="width: 15%; margin: auto;">
                        <button type="submit" class="btn btn-primary" style="width: 100%; height: 100%; margin-bottom: 2%;">Generate</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<style>
    @keyframes lighter {
        0%   {color: #0077ff;}
        33%  {color: #4094f4;}
        66%  {color: white;}
    }
    #audio_recorder {
        width: 50px;
        height: 50px;
        font-size: 120px; 
        color: #0077ff; 
        position: relative; 
        bottom: 13px;
        animation-duration: 2s;
        animation-timing-function: linear;
        animation-iteration-count: infinite;
    }
    .lighter {}

    #speech_to_text {
        font-size: 20px;
    }
    .inputs {
        margin-right: 3px;
        position: relative;
        top: 1px;
        margin-left: 4px;
    }
    .labelInput {
        margin-right: 16px;
        padding-left: 0;
        padding-top: 8px;
        padding-bottom: 8px;
    }
    .borderHover {
        border: 1px solid transparent;
        border-radius: 5px;
        width: fit-content;
        margin: auto;
    }
    .borderHover:hover {
        border: 1px solid blue;
        border-radius: 5px;
        width: fit-content;
        margin: auto;
    }
    #accuracyLevel {
        margin-left: 150px;
        margin-bottom: 10px;
    }
    .select {
        border-radius: 8px;
        height: 40px;
        width: 240px;
        background-color: transparent;
        color: white;
        border: 1px solid #0077ff;
        text-align: left;
        padding-left: 6px;
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

    #loader {
        width: 100px;
        height: 100px;
        border: 12px solid white;
        border-radius: 50%;
        margin-left: auto;
        margin-right: auto;
        margin-top: 40px;
        border-top: 12px solid #0077ff;
        width: 120px;
        height: 120px;
        animation: spin 1.5s linear infinite;
        display: block; /* Hidden by default */
        background-color: #161b22;
    }
    .loader-container {
        position: fixed;
        left: 50%;
        top: 50%;
        height: 250px;
        width: 350px;
        margin: -125px 0 0 -175px;
        background-color: #161b22;
        border-radius: 10px;
    }
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
    .cover {
        position: fixed;
        z-index: 1;
        top: 0;
        width: 100%;
        height: 100%;
        backdrop-filter: blur(20px);
        background-color: transparent;
        display: none;
    }
</style>

<script>
    const audio_text = document.getElementById("speech_to_text")

    window.onload = function() {
        const inputs = document.getElementsByClassName("inputType")
        for(let i=0;i<inputs.length;i++) {
            inputs[i].onclick = changeDisplay
        }
        document.getElementById("audio_recorder").onclick = recordAudio
        
        document.getElementById('myForm').addEventListener('submit', sendRequest)
    }

    function changeDisplay(e) {
        const type = e.target.id
        const divText = document.getElementById("textInput")
        const divAudio = document.getElementById("audioInput")

        if(type == "text") {
            changeVisibility(divText, "block", divAudio, "none")
        }
        else {
            changeVisibility(divText, "none", divAudio, "block")
        }
    }

    function changeVisibility(div1, visibility1, div2, visibility2) {
        div1.setAttribute("style", "display: " + visibility1)
        div2.setAttribute("style", "display: " + visibility2)
    }

    function recordAudio(e) {
        if ('SpeechRecognition' in window || 'webkitSpeechRecognition' in window) {
            const icon = e.target
            icon.setAttribute("style", "animation-name: lighter;")
            const recognition = new (window.SpeechRecognition || window.webkitSpeechRecognition)()
        
            recognition.lang = 'it-IT';
            recognition.interimResults = false
            recognition.maxAlternatives = 1
        
            recognition.onresult = (event) => {
                const transcript = event.results[0][0].transcript
                audio_text.innerText = transcript
                icon.setAttribute("style", "animation-name: none;")
            };
        
            recognition.start()
        } 
        else {
            console.error("Il browser non supporta l'API di riconoscimento vocale.")
        }
    }

    async function sendRequest(event) {
        showLoader()
        event.preventDefault()
        
        let formData = new FormData(this)

        let data = {}
        formData.forEach((value, key) => {
            data[key] = value
        })

        if (data.inputType === "text") 
            delete data.audio_text
        else 
            data.text = data.audio_text

        if(data.text.trim() != "") {
            const url = 'http://localhost:3000/generateNotes'

            try {
                const response = await fetch(url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: new URLSearchParams(data)
                })

                if (!response.ok) 
                    window.location.href = "../utilities/err500.php"

                const jsonResponse = await response.json()
                console.log(jsonResponse)
                let formDataPHP = new FormData()
                for (let key in jsonResponse) {
                    formDataPHP.append(key, jsonResponse[key])
                }
                console.log(formDataPHP)
                fetch('../utilities/request_handler.php', {
                    method: 'POST',
                    body: formDataPHP
                })
                .then(response => {
                    if(!response.ok)
                        throw new Error('Network response was not ok');
                    
                    if(formDataPHP.get("type") == "summary") 
                        window.location.href = "../utilities/note-pdf-generator.php"
                    else 
                        window.location.href = "../utilities/map-pdf-generator.php"
                })
            } catch (error) {
                //window.location.href = "../utilities/err500.php"
            }
        }
    }
    //loader
    function showLoader() {
        $(".cover").css("display", "block")
        $("body").css("overflow", "hidden")
        const three_points_pointer = $("#three_points")
        let times = 1
        setInterval(function() {
            if(times == 3) {
                three_points_pointer.html(three_points_pointer.html().substring(0, three_points_pointer.html().length-2))
                times = 1
            }
            else {
                three_points_pointer.html(three_points_pointer.html() + ".")
                times++
            }
        }, 800)
    }
</script>

<?php

    include('finepagina.php');

?>