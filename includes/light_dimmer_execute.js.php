<?php
    Header("Content-Type: application/javascript");

    echo "//this script looks at the value of the slider (0=>10) and forwards that value to the Gateway. Also the on-off switch on the web page is updated following the value of the slider."
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
            if ($mypoint[1] == 1) {
                echo "$(\"#div-room".$room."point".$point."slider\").on('slidestart', function() {\n";
                echo "  window.clearInterval(run_update_every_x_milliseconds);\n";
                echo "});\n";
                echo "$(\"#div-room".$room."point".$point."slider\").on('slidestop', function() {\n";
                echo "  var mhlightnumber = \"".$myroomkeys[$point]."\"\n";
                echo "  var sliderstatus = $(\"#room".$room."point".$point."slider\").val();\n";
                echo "  $.post(\"exec/ownCommand.php?frame=\" + encodeURIComponent(\"*1*\" + sliderstatus + \"*\" + mhlightnumber + \"##\"));\n";
                echo "  if (sliderstatus != \"0\") {\n";
                echo "    $(\"#room".$room."point".$point."onoff\").val('on').slider(\"refresh\");\n";
                echo "  } else {\n";
                echo "    $(\"#room".$room."point".$point."onoff\").val('off').slider(\"refresh\");\n";
                echo "  }\n";
                echo "  run_update_every_x_milliseconds = setInterval(refresh_lightstatus,1000);\n";
                echo "});\n";
            }
        }
    }
?>
