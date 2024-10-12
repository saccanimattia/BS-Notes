<?php 
    echo "
    <div id='passwordTooltip' style='display: none; position: absolute; top: 55%; right: 10%; background-color: #343A40; color: white; width: 400px; padding-left: 7px; padding-top: 4px; z-index: 1; border-radius: 6px;'>
        <p>The password must contain: </p>
        <ul>
            <li>At least one upper case char (Example: ABC)</li>
            <li>At least one lower case char (Example: abc)</li>
            <li>At least one number (Example: 123)</li>
            <li>At least one special char (!?@#+*)</li>
        </ul>
    </div>

    <script>
    window.onload = function() {
        document.getElementById('passwordTooltip').style.display = 'none';
        document.getElementById('password').onfocusin = showMyTooltip;
        document.getElementById('password').onfocusout = unshowMyTooltip;
    }
    const showMyTooltip = () => {
        $('#passwordTooltip').fadeIn(600, 'swing');
    }
    const unshowMyTooltip = () => {
        $('#passwordTooltip').fadeOut(300, 'linear');
    }
    </script>
    ";
