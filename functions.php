<?php

include 'services.php';
include 'class.php';
include 'conf.php';
$username = getUser();

function processExists($processName, $username) {
  $exists= false;
  exec("ps aux|grep $username | grep -iE $processName | grep -v grep", $pids);
  // axo user:20,pid,pcpu,pmem,vsz,rss,tty,stat,start,time,comm
  if (count($pids) > 0) {
    $exists = true;
  }
  return $exists;
}

function writeMsg($message) {
  $file = $GLOBALS['MSGFILE'];
  $Handle = fopen("/tmp/" . $file, 'w');
  fwrite($Handle, $message);
  fclose($Handle);
}

function readMsg() {
  $file = $GLOBALS['MSGFILE'];
  $Handle = fopen("/tmp/" . $file, 'r');
  $output = fgets($Handle);
  fclose($Handle);
  if (isset($output)) {
    $data = $output;
    echo $data;
  } else {
    echo "error";
  }
}


$plexURL = "http://" . $_SERVER['HTTP_HOST'] . ":31400/web/";
$reload='';
$service='';



if ($svc1 == "1") { 
	$return1 = ucfirst($service1)." <span class=\"label label-success pull-right\">Enabled</span>"; 
}
else { 
	$return1 = ucfirst($service1)." <span class=\"label label-danger pull-right\">Disabled</span>";
}

if ($svc2 == "1") { 
	$return2 = ucfirst($service2)." <span class=\"label label-success pull-right\">Enabled</span>"; 
} 
else { 
	$return2 = ucfirst($service2)."r <span class=\"label label-danger pull-right\">Disabled</span>";
}

if ($svc3 == "1") { 
	$return3 = ucfirst($service3)." <span class=\"label label-success pull-right\">Enabled</span>"; 
} 
else { 
	$return3 = ucfirst($service3)." <span class=\"label label-danger pull-right\">Disabled</span>";
}

if ($svc4 == "1") { 
	$return4 = ucfirst($service4)." <span class=\"label label-success pull-right\">Enabled</span>"; 
} 
else { 
	$return4 = ucfirst($service4)." <span class=\"label label-danger pull-right\">Disabled</span>";
}

$base = 1024;
$location = "/home";
$si_prefix = array( 'B', 'KB', 'MB', 'GB', 'TB', 'EB', 'ZB', 'YB' );
$torrents = shell_exec("ls /home/".$username."/.sessions/*.torrent|wc -l");
$php_self = $_SERVER['PHP_SELF'];
$web_path = substr($php_self, 0, strrpos($php_self, '/')+1);
$time = microtime(); $time = explode(" ", $time);
$time = $time[1] + $time[0]; $start = $time;



if (file_exists('/usr/sbin/repquota')) {
    $dftotal = shell_exec("sudo /usr/sbin/repquota /|/bin/grep ^".$username."|/usr/bin/awk '{printf \$4/1024/1024}'");
    $dffree = shell_exec("sudo /usr/sbin/repquota /|/bin/grep ^".$username."|/usr/bin/awk '{printf (\$4-\$3)/1024/1024}'");
    $dfused = shell_exec("sudo /usr/sbin/repquota /|/bin/grep ^".$username."|/usr/bin/awk '{printf \$3/1024/1024}'");
    $perused = sprintf('%1.0f', $dfused / $dftotal * 100);

} else {
    try {
        $diskStatus = new DiskStatus('/home/'.$username);
        $freeSpace = $diskStatus->freeSpace();
        $totalSpace = $diskStatus->totalSpace();
		$usedSpace = $diskStatus->totalSpace()-$diskStatus->freeSpace();
    } catch (Exception $e) {
        $spacebodyerr .= 'Error ('.$e-getMessage().')';
        exit();
    }
    $dffree = $diskStatus->addUnits($freeSpace); //.'<b>'.$si_prefix[$class].'</b> Free<br/>'
    $dfused = $diskStatus->addUnits($usedSpace); //.'<b>'.$si_prefix[$class].'</b> Used<br/>'
    $dftotal = $diskStatus->addUnits($totalSpace); //.'<b>'.$si_prefix[$class].'</b> Total<br/>'
    $perused = sprintf('%1.0f', $usedSpace * 100 / $totalSpace);
}

if (file_exists('/home/'.$username.'/.session/rtorrent.lock')) {
      $rtorrents = shell_exec("ls /home/".$username."/.session/*.torrent|wc -l");
}

$notready= 'Not Ready';
$load = sys_getloadavg();
$data1 = shell_exec('uptime');
$uptime = explode(' up ', $data1);
$uptime = explode(',', $uptime[1]);
$uptime = $uptime[0];

?>