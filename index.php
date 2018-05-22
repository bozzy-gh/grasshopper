<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">

    <title>Grasshopper</title>

    <link rel="stylesheet" href="themes/custom.min.css" />
    <link rel="stylesheet" href="themes/jquery.mobile.icons.min.css" />
    <link rel="stylesheet" href="includes/jquery.mobile.structure-1.4.5.min.css" />
    <script src="includes/jquery-1.11.1.min.js"></script>
    <script src="includes/jquery.mobile-1.4.5.min.js"></script>

    <link rel="stylesheet" type="text/css" href="css/grasshopper.css">

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

    <script>
        $(window).load(function() {
            $('#loading').hide();
        });
    </script>


    <?php include(dirname(__FILE__)."/js/refresh_lightstatus_from_db.php"); ?>
    <?php include(dirname(__FILE__)."/js/sliderupdates.php"); ?>
    <?php include(dirname(__FILE__)."/js/onoffsliderupdates.php"); ?>

    <script src="includes/ajax_submit.js"></script>
    <script src="includes/continuously_update_status.js"></script>

</body>

</html>
