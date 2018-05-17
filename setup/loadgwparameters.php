<?php
    $returnhome = array();
    $myhome = parse_ini_file('../exec/ownGateway.conf', true);
    $myhomevalues = array_values($myhome);
	echo json_encode($myhomevalues);
?>
