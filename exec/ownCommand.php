<?php
    // this file is used by sliderupdates.js, onoffsliderupdates.js and controls.php to send any frame (light, automation, etc.) to BTicino MyHome

    require('ownGateway.php');

    $scom = ownConnect(COMMANDS);
    if ($scom) {
        try {
            if (!empty($_GET['frame'])) {
                fwrite($scom, $_GET['frame']);
            }
        } catch (Exception $e) {}
        fclose($scom);
    }
?>