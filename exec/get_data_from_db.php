<?php
    // this file is called from ./js/refresh_lightstatus_from_db.js
    //It will make the actual connection to the DB and echo the output to ./js/refresh_lightstatus_from_db.js for processing.

    // Create an array
    $rows = array();

    if (is_file("/var/www/db/grasshopper.sqlite")) {
        $sqlite = new SQLite3("/var/www/db/grasshopper.sqlite", SQLITE3_OPEN_READONLY);
    }

    if (!empty($sqlite)) {
        // Execute query and get results into recordset
        if (!empty($_GET["selquery"])) {
            $result = $sqlite->query("SELECT ".$_GET["selquery"]);
        } elseif (!empty($_GET["table"])) {
            $result = $sqlite->query("SELECT * FROM ".$_GET["table"]);
        }

        // Fetch and populate array
        if (!empty($result)) {
            while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
                $rows[]=$row;
            }
        }

        // Close recordset and connection
        $sqlite->close();
    }

    // Convert array to json format
    echo json_encode(array('groups'=>$rows));
?>