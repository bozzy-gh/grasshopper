<?php
    Header("Content-Type: application/javascript");

    echo "//TO BE ADJUSTED ---> this script looks at the value of the on-off switch and forwards that value to the Gateway. If it is a dimmable light, also the slider (0=>10) is updated on the webpage."
    $myhome = parse_ini_file(dirname(__FILE__).'/myhome.conf', true);
    $myhomevalues = array_values($myhome);
    $roomscount = count($myhome);
    for ($room = 0; $room < $roomscount; $room++) {
        $myroom = $myhomevalues[$room];
        $myroomkeys = array_keys($myroom);
        $myroomvalues = array_values($myroom);
        $pointscount = count($myroom);
        for ($point = 0; $point < $pointscount; $point++) {
            $mypoint = explode(',', $myroomvalues[$point]);
            if (!isset($mypoint[1])) {
                $mypoint[1] = 0;
            }
            if ($mypoint[1] == 4) {
                echo "$(\"#room".$room."split".$point."button\").bind('click', function() {\n";
                echo "  var mhpointnumber = \"".$myroomkeys[$point]."\";\n";
                echo "  var mhpointmode = $(\"#room".$room."split".$point."mode\").val();\n";
                echo "  var mhpointtemp = $(\"#room".$room."split".$point."temp\").val() * 10;\n";
                echo "  var mhpointspeed = $(\"#room".$room."split".$point."speed\").val();\n";
                echo "  if ($(\"#room".$room."split".$point."swing\").prop(\"checked\")) {\n";
                echo "    var mhpointswing = \"1\";\n";
                echo "  } else {\n";
                echo "    var mhpointswing = \"0\";\n";
                echo "  }\n";
                echo "  $.post(\"exec/ownCommand.php?frame=\" + encodeURIComponent(\"*#4*3#11#\" + mhpointnumber + \"*#22*\" + mhpointmode + \"*\" + mhpointtemp + \"*\" + mhpointspeed + \"*\" + mhpointswing + \"##\"));\n";
                echo "});\n";
            }
        }
    }
?>
