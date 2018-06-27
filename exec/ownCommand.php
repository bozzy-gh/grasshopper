<?php
    // this file is used by light_on-off_execute.js.php, light_dimmer_execute.js.php, split_execute.js.php and controls.html.php to send any frame (light, automation, etc.) to BTicino MyHome

    require dirname(__FILE__).'/ownGateway.php';

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