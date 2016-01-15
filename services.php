<?php
include 'conf.php';
$username = getUser();

if (strtolower($service1) == "rtorrent") {
  $svc1 = processExists($service1,$username);
}
else {
  $svc1 = processExists($service1,$service_name1);
}
$svc2 = processExists($service2,$service_name2);
$svc3 = processExists($service3,$service_name3);

if (strtolower($media) == "emby") {
  $svc4 = processExists("Emby",$service_name4);
  $medname = "Emby";
}
elseif (strtolower($media) == "plex") {
  $svc4 = processExists("Plex",$service_name4);
  $medName = "Plex";
}

?>