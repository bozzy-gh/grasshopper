<?php

$arr = json_decode($_POST["arr"]);
//echo $_POST["arr"];

$myhomeconfigfile = "../exec/ownGateway.conf";
$fh = fopen($myhomeconfigfile, 'w') or die("can't open file");

fwrite($fh, '[GATEWAY]' . chr(10));
//print_r($arr);
foreach ($arr[0] as $key => $value ) {

	fwrite($fh, $key . '=' . $value . chr(10));
}
fclose($fh);

?>