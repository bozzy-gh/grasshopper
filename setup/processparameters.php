<?php

$arr = json_decode($_POST["arr"]);
//echo $_POST["arr"];

$myhomeconfigfile = "../includes/myhome.conf";
$fh = fopen($myhomeconfigfile, 'w') or die("can't open file");

foreach ($arr as $room) {

echo '________THIS IS THE $arr VARIABLE______________';
print_r ($arr);
echo '________THIS IS THE $arr VARIABLE______________';
echo '________THIS IS THE $room VARIABLE______________';
print_r ($room);
echo '________THIS IS THE $room VARIABLE______________';

// if ($key == "_RowCount"){
//  unset($key);
//  continue;
//  }

  foreach ( $room as $key => $value ) {

// if ($key == "_RowCount"){
//  continue;
//  }
    if ($key == "roomname") {
        fwrite($fh, '["' . addcslashes($value, '"') . '"]' . chr(10));
    }
//  echo $key, chr(10);
//  echo $value, chr(10);
        if (substr( $key, 0, 13 ) == "bticinonumber") {
            fwrite($fh, $value . "=");
        }

        if (substr( $key, 0, 16 ) == "controlpointname") {
            fwrite($fh, '"' . addcslashes($value, '"') . '"');
        }

        if (substr( $key, 0, 16 ) == "controlpointtype") {
            fwrite($fh, "," . $value . chr(10));
        }

  }

}

fclose($fh);

?>