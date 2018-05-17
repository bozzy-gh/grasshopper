//this script calls exec/get_data_from_db.php to get the latest status from the DB. Based on the feedback, it updates sliders and on-off sliders in the UI.

//this function is comrpised of 4 parts:
//1. get the latest statuses from MySQL
//2. put every lightstatus in a variable
//3. update the sliders and onoff sliders on the web page
//4. update the number on every room-heading
//In each part, I describe what to change.

<script type="text/javascript">

//1. this function refresh_lightstatus() is also called from js/sliderupdates.js and js/onoffsliderupdates.js
function refresh_lightstatus() {
    var url="exec/get_data_from_db.php?table=pointstatus";

    $.getJSON(url, function(data) {

//2. every element of the json array will be reviewed and put in a variable for each light point

        for(var i = 0, numrows = data.groups.length; i < numrows; i++) {

            <?php
                $myhome = parse_ini_file('includes/myhome.conf', true);
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
                            echo "if ((data.groups[i].btaddress == \"".$myroomkeys[$point]."\") && (data.groups[i].btgroup == 1)) {\n";
                            echo "    room".$room."point".$point."status = data.groups[i].status;\n";
                            echo "}\n";
                        }
                    }
                }
            ?>

        }

        <?php
            $myhome = parse_ini_file('includes/myhome.conf', true);
            $myhomevalues = array_values($myhome);
            $roomscount = count($myhome);

//3. update the sliders and onoff sliders on the webpage
// So lightpoints without a dimmer only refresh the value of the on-off slider and with a dimmer also need to refresh the value of the dimmer-slider
// I have put comments with frontdoorledsstatus to indicate what may need to be changed for lightpoints without a dimmer and
// I put comments with kitchensinkstatus to indicate what may need to be changed for lightpoints with a dimmer

            for ($room = 0; $room < $roomscount; $room++) {
                $myroom = $myhomevalues[$room];
                $myroomvalues = array_values($myroom);
                $pointscount = count($myroom);
                for ($point = 0; $point < $pointscount; $point++) {
                    $mypoint = explode(',', $myroomvalues[$point]);
                    if (!isset($mypoint[1])) {
                        $mypoint[1] = 0;
                    }
                    if (($mypoint[1] == 0) || ($mypoint[1] == 1)) {
                        echo "if (typeof room".$room."point".$point."status != 'undefined') {\n";
                        echo "    if (room".$room."point".$point."status != \"0\") {\n";
                        echo "        $(\"#room".$room."point".$point."onoff\").val('on').slider(\"refresh\")\n";
                        echo "    }\n";
                        echo "    else {\n";
                        echo "        $(\"#room".$room."point".$point."onoff\").val('off').slider(\"refresh\")\n";
                        echo "    }\n";
                        if ($mypoint[1] == 1) {
                            echo "    $(\"#room".$room."point".$point."slider\").val(Number(room".$room."point".$point."status)).slider(\"refresh\");\n";
                        }
                        echo "}\n";
                    }
                }
            }

//4. update the number in each room-heading
// we evaluate whether each of the lightpoints of a room  is 0 or not and update the number-bubble in the heading accordingly.

            for ($room = 0; $room < $roomscount; $room++) {
                $myroom = $myhomevalues[$room];
                $myroomvalues = array_values($myroom);
                echo "update".$room."counter = 0;\n";
                $pointscount = count($myroom);
                for ($point = 0; $point < $pointscount; $point++) {
                    $mypoint = explode(',', $myroomvalues[$point]);
                    if (!isset($mypoint[1])) {
                        $mypoint[1] = 0;
                    }
                    if (($mypoint[1] == 0) || ($mypoint[1] == 1)) {
                        echo "if (typeof room".$room."point".$point."status != 'undefined') {\n";
                        echo "    if (room".$room."point".$point."status != \"0\") {\n";
                        echo "        update".$room."counter++;\n";
                        echo "    }\n";
                        echo "}\n";
                    }
                }
                echo "$(\"#room".$room."counter\").text(update".$room."counter);\n";
            }
        ?>

    });

}

</script>