<?php
if($_SERVER["REQUEST_METHOD"] == "GET") {
    session_start();
    $note = $_SESSION["note"];
    $ispublic = $_SESSION["isPublic"];
    preg_match('/##(.*?)##/', $note, $matches);
    $title = $matches[1];


    preg_match_all('/@@(.*?)@@/', $note, $subtitles, PREG_SET_ORDER);
    preg_match_all('/!!(.*?)!!/', $note, $bodies, PREG_SET_ORDER);

    
    $paragraphs = array();
    if(count($subtitles) == count($bodies)) {
        for($i = 0; $i < count($subtitles); $i++) {
            $paragraphs[$i] = array("paragrapTitle" => $subtitles[$i][1], "paragraphBody" => $bodies[$i][1]);
        }
    }

    $materia = $_SESSION["subject"];

    $appunto = "
    <div class='bg-dark border-primary rounded m-auto pb-5 pt-3' style='width:85%;'>
    ";

    foreach($paragraphs as $paragraph) {
        $appunto .= "
            <div class='paragraph border-primary '>
                <div class='font-weight-bold mb-3 heading-note'>
                    <h2 class='paragraph-title pl-5'>" .$paragraph['paragrapTitle'] ."</h2>
                </div>
                <div class='body m-auto text-white' style='width:95%'>
                    <p class='paragraph-body lead text-justify'>" .$paragraph['paragraphBody'] ."</p>
                </div>
            </div>";
    }
    
    $appunto .= "</div>";
}
else {
    include "../utilities/redirect.php";
    redirect("../utilities/err400.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <div id="diagram-container">
        <?php echo $appunto; ?>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(createPDF, 1000)
        });

        function createPDF() {
            
            var pdfContent = document.getElementById('diagram-container').innerHTML;
            var visibilita = `<?php echo $ispublic; ?>`;
            if(visibilita == "") {
                sendError();
            }
            if(pdfContent.includes('aria-roledescription="error"')) {
                sendError();
            }
            const options = {
                margin: [20, 30, 0, 30],
                filename: `<?php echo $title; ?>.pdf`,
                html2canvas: {
                    scale: 0.7      
                },
                jsPDF: { unit: 'mm', format: [300, 200], orientation: 'landscape' }
            };
            html2pdf().from(pdfContent).set(options).toPdf().get('pdf').then(function(pdf) {
                sendPDF(pdf, pdfContent, visibilita);
            });
        }

        function sendPDF(pdf, pdfContent, visibilita) {

            var formData = new FormData();
            formData.append('pdf', pdf.output('blob'));
            formData.append('title', `<?php echo $title; ?>`);
            formData.append('materia', `<?php echo $materia; ?>`);
            formData.append('html', pdfContent);
            formData.append('visibilita', visibilita);
            formData.append('categoria', `2`);
            

            fetch('saveNote.php', {
                method: 'POST',
                body: formData
            }).then(response => {
                if(response.ok) {
                    window.location.href = "../routes/myNotes.php";
                }
                else {
                    sendError();
                }
            });
        }
        function sendError() {
            
        }
    </script>
</body>
</html>
