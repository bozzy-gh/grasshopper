<?php
    $returnhome = array();
    $myhome = parse_ini_file(dirname(__FILE__).'/../exec/ownGateway.conf', true);
    $myhomevalues = array_values($myhome);
	echo json_encode($myhomevalues);
?>
