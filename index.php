<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">

    <title>Grasshopper</title>

    <?php include(dirname(__FILE__)."/includes/jquerymobile.php"); ?>

    <link rel="stylesheet" type="text/css" href="css/grasshopper.css">

    <?php include(dirname(__FILE__)."/includes/snippet_myajaxrequest.php"); ?>

    <meta content="minimum-scale=1.0, width=device-width, maximum-scale=1.0, user-scalable=0" name="viewport" />

    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="pics/icon.png">
    <link rel="icon" type="image/ico" href="favicon.ico">
</head>

<body>
    <div id="loading">
        <img id="loading-image" src="pics/pageloader.gif" alt="Loading..." />
    </div>

    <div data-role="page" id="pageone" data-inset="true" data-theme="a" data-content-theme="a">
        <div data-role="header">
            <h2>Grasshopper</h2>
        </div>
        <div data-role="collapsible-set" data-inset="true">
            <?php include(dirname(__FILE__)."/includes/controls.php"); ?>
        </div>
    </div>

    <script language="javascript" type="text/javascript">
        $(window).load(function() {
            $('#loading').hide();
        });
    </script>
</body>

<?php include(dirname(__FILE__)."/js/refresh_lightstatus_from_db.js"); ?>
<?php include(dirname(__FILE__)."/js/sliderupdates.js"); ?>
<?php include(dirname(__FILE__)."/js/onoffsliderupdates.js"); ?>
<?php include(dirname(__FILE__)."/includes/continuously_update_status.php"); ?>

</html>
