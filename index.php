<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">

    <title>Grasshopper</title>

    <link rel="stylesheet" href="jquery/themes/custom.min.css" />
    <link rel="stylesheet" href="jquery/themes/jquery.mobile.icons.min.css" />
    <link rel="stylesheet" href="jquery/jquery.mobile.structure-1.4.5.min.css" />
    <script src="jquery/jquery-1.11.1.min.js"></script>
    <script src="jquery/jquery.mobile-1.4.5.min.js"></script>

    <link rel="stylesheet" type="text/css" href="css/grasshopper.css">
    <script src="includes/ajax_submit.js"></script>
    <script src="includes/continuously_update_status.js"></script>
    <script src="includes/refresh_lightstatus_from_db.js.php"></script>
    <script src="includes/light_on-off_execute.js.php"></script>
    <script src="includes/light_dimmer_execute.js.php"></script>

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
<?php require dirname(__FILE__).'/includes/controls.php'; ?>
    </div>
  </div>

  <script>
    $(window).load(function() {
      $('#loading').hide();
    });
  </script>
</body>

</html>
