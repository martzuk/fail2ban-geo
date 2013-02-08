<?php
	require_once "functions.inc.php";
	
	$key = (isset($_GET["key"]))? $_GET["key"] : NULL;
	$ip = (isset($_GET["ip"]))? $_GET["ip"] : NULL;
	
	if($key == $config["access"]["key"])
	{
		addIp($ip);
	}
?>