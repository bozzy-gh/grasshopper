<?php
    Header("Content-Type: application/javascript");

    echo "//this script looks at the value of the on-off switch and forwards that value to the Gateway. If it is a dimmable light, also the slider (0=>10) is updated on the webpage."
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
            if (($mypoint[1] == 0) || ($mypoint[1] == 1)) {
                echo "$(\"#room".$room."point".$point."onoff\").on('slidestart', function() {\n";
                echo "  window.clearInterval(run_update_every_x_milliseconds);\n";
                echo "});\n";
                echo "$(\"#room".$room."point".$point."onoff\").on('slidestop', function() {\n";
                echo "  var mhlightnumber = \"".$myroomkeys[$point]."\";\n";
                echo "  var onoffstatus = $(this).val();\n";
                echo "  if (onoffstatus != \"off\") {\n";
                if ($mypoint[1] == 1) {
                    echo "    var onoffstatusvalue = 10\n";
                } else {
                    echo "    var onoffstatusvalue = 1\n";
                }
                echo "  } else {\n";
                echo "    var onoffstatusvalue = 0;\n";
                echo "  }\n";
                echo "  $.post(\"exec/ownCommand.php?frame=\" + encodeURIComponent(\"*1*\" + onoffstatusvalue + \"*\" + mhlightnumber + \"##\"));\n";
                if ($mypoint[1] == 1) {
                    echo "  $(\"#room".$room."point".$point."slider\").val(onoffstatusvalue).slider(\"refresh\");\n";
                }
                echo "  run_update_every_x_milliseconds = setInterval(refresh_lightstatus, 1000);\n";
                echo "});\n";
            } else if ($mypoint[1] == 3) {
                echo "$(\"#room".$room."point".$point."button\").bind('click', function() {\n";
                echo "  var mhlightnumber = \"".$myroomkeys[$point]."\";\n";
                echo "  $.post(\"exec/ownCommand.php?frame=\" + encodeURIComponent(\"*1*18*\" + mhlightnumber + \"##\"));\n";
                echo "});\n";
            }
        }
    }
?>
