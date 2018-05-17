<?php
    $myhome = parse_ini_file('includes/myhome.conf', true);
    $myhomekeys = array_keys($myhome);
    $myhomevalues = array_values($myhome);
    $roomscount = count($myhome);
    for ($room = 0; $room < $roomscount; $room++) {
        $myroom = $myhomevalues[$room];
        $myroomkeys = array_keys($myroom);
        $myroomvalues = array_values($myroom);
        echo "<div data-role=\"collapsible\">\n";
        echo "    <h2><div class=\"ui-btn-up-c ui-btn-corner-all custom-count-pos\" name=\"room".$room."counter\" id=\"room".$room."counter\"></div>".$myhomekeys[$room]."</h2>\n";
        echo "    <ul data-role=\"listview\" data-split-theme=\"a\" class=\"listviewclass\">\n";
        $pointscount = count($myroom);
        for ($point = 0; $point < $pointscount; $point++) {
            $mypoint = explode(',', $myroomvalues[$point]);
            if (!isset($mypoint[1])) {
                $mypoint[1] = 0;
            }
            echo "        <li>\n";
            echo "            <fieldset class=\"ui-grid-b\">\n";
            echo "                <div class=\"ui-block-a\" style=\"width:25%\">".$mypoint[0]."</div>\n";
            if ($mypoint[1] == 2) {
                echo "                <div class=\"ui-block-b\" style=\"width:50%\">\n";
                echo "                    <div data-role=\"controlgroup\" data-type=\"horizontal\" data-mini=\"true\" align=\"center\">\n";
                echo "                        <a href=\"javascript:openpage('exec/ownCommand.php?frame=' + encodeURIComponent('*2*2*".$myroomkeys[$point]."##'))\" data-role=\"button\" data-icon=\"arrow-d\" data-iconpos=\"notext\" align=\"right\">Down</a>\n";
                echo "                        <a href=\"javascript:openpage('exec/ownCommand.php?frame=' + encodeURIComponent('*2*0*".$myroomkeys[$point]."##'))\" data-role=\"button\" data-icon=\"delete\" data-iconpos=\"notext\" align=\"right\">Stop</a>\n";
                echo "                        <a href=\"javascript:openpage('exec/ownCommand.php?frame=' + encodeURIComponent('*2*1*".$myroomkeys[$point]."##'))\" data-role=\"button\" data-icon=\"arrow-u\" data-iconpos=\"notext\" align=\"right\">Up</a>\n";
                echo "                    </div>\n";
                echo "                </div>\n";
                echo "                <div class=\"ui-block-c\" style=\"width:25%\"></div>\n";
            } else if ($mypoint[1] == 3) {
                echo "                <div class=\"ui-block-b\" style=\"width:50%\"></div>\n";
                echo "                <div class=\"ui-block-c\" style=\"width:25%\">\n";
                echo "                    <div data-role=\"controlgroup\" data-type=\"horizontal\" data-mini=\"true\" align=\"right\">\n";
                echo "                        <button class=\"ui-btn ui-icon-power ui-btn-icon-notext\" name=\"room".$room."point".$point."button\" id=\"room".$room."point".$point."button\">Button</button>\n";
                echo "                    </div>\n";
                echo "                </div>\n";
            } else {
                if ($mypoint[1] == 1) {
                    echo "                <div class=\"ui-block-b\" style=\"width:50%\" id=\"div-room".$room."point".$point."slider\">\n";
                    echo "                    <input name=\"room".$room."point".$point."slider\" id=\"room".$room."point".$point."slider\" data-mini=\"true\" min=\"2\" max=\"10\" data-highlight=\"true\" type=\"range\">\n";
                    echo "                </div>\n";
                } else {
                    echo "                <div class=\"ui-block-b\" style=\"width:50%\"></div>\n";
                }
                echo "                <div class=\"ui-block-c\" style=\"width:25%\">\n";
                echo "                    <span class=\"fliper\">\n";
                echo "                        <select name=\"room".$room."point".$point."onoffslider\" id=\"room".$room."point".$point."onoff\" data-role=\"slider\" data-mini=\"true\">\n";
                echo "                            <option value=\"off\">Off</option>\n";
                echo "                            <option value=\"on\">On</option>\n";
                echo "                        </select>\n";
                echo "                    </span>\n";
                echo "                </div>\n";
            }
            echo "            </fieldset>\n";
            echo "        </li>\n";
        }
        echo "    </ul>\n";
        echo "</div>\n";
    }
?>
