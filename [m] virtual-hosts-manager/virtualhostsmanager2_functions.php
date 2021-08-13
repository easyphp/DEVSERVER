<?php
/**
 * Virtual Hosts Manager for DEVSERVER
 * @version  2.0
 * @author   Laurent Abbal <laurent@abbal.com>
 * @link     http://www.easyphp.org
 */

if (!function_exists('get_hostsfile_dir')) {
	function get_hostsfile_dir() {
		$hostlist = array(
			// 95, 98/98SE, Me 	%WinDir%\
			// NT, 2000, and 32-bit versions of XP, 2003, Vista, 7 	%SystemRoot%\system32\drivers\etc\
			// 64-bit versions 	%SystemRoot%\system32\drivers\etc\
			'' => '#Windows 95|Win95|Windows_95#i',
			'' => '#Windows 98|Win98#i',
			'' => '#Windows ME#i',	
			'\system32\drivers\etc' => '#Windows NT 4.0|WinNT4.0|WinNT|Windows NT#i',			
			'\system32\drivers\etc' => '#Windows NT 5.0|Windows 2000#i',
			'\system32\drivers\etc' => '#Windows NT 5.1|Windows XP#i',
			'\system32\drivers\etc' => '#Windows NT 5.2#i',
			'\system32\drivers\etc' => '#Windows NT 6.0#i',
			'\system32\drivers\etc' => '#Windows NT 7.0#i',
		);
		foreach($hostlist as $hostdir=>$regex) {
			if (preg_match($regex, $_SERVER['HTTP_USER_AGENT'])) break;
		}
		// Return FALSE is hosts cannot be opened
		$hosts_path = getenv('windir').$hostdir;
		return $hosts_path;
	}
}

if (!function_exists('read_hostsfile')) {
	function read_hostsfile($part) {
		$hostsfile_array = array();
		$hosts_array = array();
		$hostsfile = @file_get_contents(get_hostsfile_dir().'\hosts');
		$hostsfile_array = explode("\n",$hostsfile);
		foreach ($hostsfile_array as $line) {
			if((stripos($line,'127.0.0.1') !== false) and ((stripos($line,'127.0.0.1')) < 3)) {
				$line_array = explode('127.0.0.1', $line);
				$hosts_array[] = trim($line_array[1]);
			}
		}
		if ($part == 'file') return $hostsfile_array;
		if ($part == 'hosts') return $hosts_array;
	}
}
?>