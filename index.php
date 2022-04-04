<?php

require_once 'config.php';
require_once 'locale/'.LOCALE.'.php';
ini_set('error_reporting',ERROR_REPORTING);
ini_set('display_errors',DISPLAY_ERRORS);

require_once 'hosts.php';
require_once 'include/functions.php';
include 'include/template/head.php';
?>
			<h1><?=TITLE?></h1>
			<p><?=checks_network_status?></p>
			<div id="listing">
<?php
foreach ($hosts as $host) {
	//if the host is an IP already then skip resolving
	if (!filter_var($host['name'],FILTER_VALIDATE_IP)) {
		$address = resolve($host['name']);
		$id = $host['name'].'<br />'.$address;
	}
	else {
		$address = $host['name'];
		$id = $address;
	}
	if ($address !== false) {
		//ICMP
		if (ping($address)) {
			$icmp_class = ' green';
		}
		else {
			$icmp_class = ' red';
		}
		/*
		 * the socket is tested independently from ICMP echo
		 * because in some (not so) exotic cases it is filtered out
		 * in purpose
		 */
		$lapse = socket($address,$host['port']).'ms';
		if ($lapse != -1) {
			$socket_class = ' green';
		}
		else {
			$lapse = '';
			$socket_class = ' red';
		}
		//light pilot switcher
		if ($icmp_class == ' green' && $socket_class == ' green') {
			$health_class = ' green';
		}
		else if ($icmp_class == ' red' && $socket_class == ' red') {
			$health_class = ' red';
		}
		else {
			$health_class = ' orange';
		}
	}
	else {
		//DNS has failed
		$lapse = '';
		$icmp_class = ' red';
		$socket_class = ' red';
		$health_class = ' red';
	}
	echo '				<div class="host">'."\n";
	echo '					<div class="lamp'.$health_class.'"></div>'."\n";
	echo '					<div class="name">'.$id.'<br /><span class="description">'.$host['description'].'</span></div>'."\n";
	echo '					<div class="lamp'.$icmp_class.'"></div>'."\n";
	echo '					<div class="icmp">ICMP</div>'."\n";
	echo '					<div class="lamp'.$socket_class.'"></div>'."\n";
	echo '					<div class="socket"><strong>'.$host['port'].'</strong><br />'.$lapse.'</div>'."\n";
	echo '				</div>'."\n";
}
echo "			</div>\n";

include 'include/template/base.php';

?>
