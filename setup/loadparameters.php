<?php
    $returnhome = array();
    $myhome = parse_ini_file('../includes/myhome.conf', true);
    $myhomekeys = array_keys($myhome);
    $myhomevalues = array_values($myhome);
    $roomscount = count($myhome);
    for ($room = 0; $room < $roomscount; $room++) {
        $returnroom = array();
        $myroom = $myhomevalues[$room];
        $myroomkeys = array_keys($myroom);
        $myroomvalues = array_values($myroom);
        $pointscount = count($myroom);
        for ($point = 0; $point < $pointscount; $point++) {
            $mypoint = explode(',', $myroomvalues[$point]);
            if (!isset($mypoint[1])) {
                $mypoint[1] = 0;
            }
            $returnroom[] = array("bticinonumber" => $myroomkeys[$point], "controlpointname" => $mypoint[0], "controlpointtype" => $mypoint[1]);
        }
        $returnhome[] = array("roomname" => $myhomekeys[$room], "SubGridData" => $returnroom);
    }
    echo json_encode($returnhome);
?>
