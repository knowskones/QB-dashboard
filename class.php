<?php
class DiskStatus {
	 const RAW_OUTPUT = true;
	private $diskPath;
	function __construct($diskPath) {
	$this->diskPath = $diskPath;
}
public function totalSpace($rawOutput = false) {
	$diskTotalSpace = disk_total_space($this->diskPath);
	if ($diskTotalSpace === FALSE) {
		throw new Exception('totalSpace(): Invalid disk path.');
	}
	return $diskTotalSpace;
}
public function freeSpace($rawOutput = false) {
	$diskFreeSpace = disk_free_space($this->diskPath);
	if ($diskFreeSpace === FALSE) {
		throw new Exception('freeSpace(): Invalid disk path.');
	}
	return $diskFreeSpace;
}

public function getDiskPath() {
	return $this->diskPath;
}
public function addUnits($bytes) {
	$units = array( 'B', 'KB', 'MB', 'GB', 'TB' );
	for($i = 0; $bytes >= 1024 && $i < count($units) - 1; $i++ ) {
		$bytes /= 1024;
		$retour = round($bytes, 1).' '.$units[$i];
	}
		return $retour;
	}
}
?>