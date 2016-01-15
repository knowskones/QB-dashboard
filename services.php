<?php
include 'conf.php';
$username = getUser();

$rtorrent = processExists("\"main|rtorrent\"",$username);
$docker = processExists("docker","root");
$btsync = processExists("btsync",$username);

if (strtolower($media) == "emby") {
$medplayer = processExists("Emby","root");
$medname = "Emby";
}
elseif (strtolower($media) == "plex") {
$medplayer = processExists("Plex","root");
$medName = "Plex";
}

?>