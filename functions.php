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

function isEnabled($search, $username){
  $string = file_get_contents('/home/'.$username.'/.startup');
  $service = $search;
  if(preg_match("/\b".$search."\b/", $string)){
    return " <div class=\"toggle-wrapper pull-right\"><div class=\"toggle-en toggle-light primary\" onclick=\"location.href='?id=77&serviceend=$service'\"></div></div>";
  } else {
    return " <div class=\"toggle-wrapper pull-right\"><div class=\"toggle-dis toggle-light primary\" onclick=\"location.href='?id=66&servicestart=$service'\"></div></div>";
  }
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



if ($rtorrent == "1") { $rval = "RTorrent <span class=\"label label-success pull-right\">Enabled</span>"; 
} else { $rval = "RTorrent <span class=\"label label-danger pull-right\">Disabled</span>";
}

if ($docker == "1") { $ival = "Docker <span class=\"label label-success pull-right\">Enabled</span>"; 
} else { $ival = "Docker <span class=\"label label-danger pull-right\">Disabled</span>";
}

if ($btsync == "1") { $bval = "BTSync <span class=\"label label-success pull-right\">Enabled</span>"; 
} else { $bval = "BTSync <span class=\"label label-danger pull-right\">Disabled</span>";
}

if ($medplayer == "1") { $pval = $medname." <span class=\"label label-success pull-right\">Enabled</span>"; 
} else { $pval = "Emby <span class=\"label label-danger pull-right\">Disabled</span>";
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