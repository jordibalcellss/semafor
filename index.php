<?php

/**
 * semafor
 *
 * Copyright 2022 by Jordi Balcells <jordi@balcells.io>
 *
 * This program is free software: you can redistribute it and/or modify it under
 * the terms of the GNU General Public License as published by the Free Software 
 * Foundation, either version 3 of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A
 * PARTICULAR PURPOSE. See the GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License along with this progra
 * If not, see <https://www.gnu.org/licenses/>.
 */

require 'config.php';
require 'locale/'.LOCALE.'.php';
ini_set('error_reporting',ERROR_REPORTING);
ini_set('display_errors',DISPLAY_ERRORS);

require 'hosts.php';
require 'include/functions.php';
require 'include/template/head.php';
?>
      <h1><?=TITLE?></h1>
      <p><?=checks_network_status?></p>
      <div id="listing">
<?php
foreach ($hosts as $host) {
  //if the host is an IP already then skip resolving
  if (!filter_var($host['name'],FILTER_VALIDATE_IP)) {
    //validated as an hostname
    if (substr($host['name'],0,6) == 'udp://') {
      //remove the prefix
      $host['name'] = substr($host['name'],6,strlen($host['name']));
      $prefix = 'udp://';
    }
    else {
      $prefix = '';
    }
    $address = resolve($host['name']);
    if ($address) {
      //resolved
      $id = $host['name'].'<br />'.$address;
    }
    else {
      //unresolved, ignore
      continue;
    }
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
    $lapse = socket($prefix,$address,$host['port']).'ms';
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
  echo '        <div class="host">'."\n";
  echo '          <div class="lamp'.$health_class.'"></div>'."\n";
  echo '          <div class="name">'.$id.'<br /><span class="description">'.$host['description'].'</span></div>'."\n";
  echo '          <div class="lamp'.$icmp_class.'"></div>'."\n";
  echo '          <div class="icmp">ICMP</div>'."\n";
  echo '          <div class="lamp'.$socket_class.'"></div>'."\n";
  echo '          <div class="socket"><strong>'.$host['port'].'</strong><br />'.$lapse.'</div>'."\n";
  echo '        </div>'."\n";
}
echo "      </div>\n";

require 'include/template/base.php';

?>
