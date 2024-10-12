<?php
if($_SERVER["REQUEST_METHOD"] == "GET") {
    session_start();
    $map = $_SESSION["noteGenerated"];
    $ispublic = $_SESSION["isPublic"];
    $title = substr($map, strpos($map, "root(")+5, strpos($map, ")") - strpos($map, "root(")-5);
    $materia = $_SESSION["subject"];
    $map = str_replace("_NL_", "\n", $map);
    $map = str_replace("_TAB_", "  ", $map);
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
    <script src="https://cdn.jsdelivr.net/npm/mermaid@10.8.0/dist/mermaid.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
</head>
<body>
    <div id="diagram-container">
        <pre id="map" class="mermaid">
        </pre>
    </div>

    <script>
        document.getElementById('map').innerHTML = `<?php echo $map; ?>`;
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(createPDF, 1000)
        });
        mermaid.initialize({ startOnLoad: true });

        function createPDF() {
            
            var pdfContent = document.getElementById('map').innerHTML;
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
                    scale: 1           
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
