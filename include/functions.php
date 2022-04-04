<?php

function resolve($hostname) {
	//returns false if record is not found
	$address = @dns_get_record($hostname,DNS_A)[0]['ip'];
	if ($address == NULL) {
		return false;
	}
	else {
		return $address;
	}
}

function ping($address) {
	//returns true on success (echo reply received)
	$status_code = shell_exec("ping -q -c1 $address >/dev/null; echo $?");
	if ($status_code == 0) {
		return true;
	}
	else {
		return false;
	}
}

function socket($address,$port) {
	//returns -1 on failure, 3-way handshake time (ms) on success
	$starttime = microtime(true);
	$file = @fsockopen($address,$port,$errno,$errstr,1);
	$stoptime = microtime(true);
	
	if (!$file) {
		$status = -1;
	}
	else {
		fclose($file);
		$status = floor(($stoptime - $starttime) * 1000);
	}
	return $status;
}

?>
