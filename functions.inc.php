<?php
	//Import configuration details
	$config = require "config.inc.php";

	//Create New PDO connection variable
	try
	{
		$db = new PDO($config["pdo"]["dsn"], $config["pdo"]["username"], $config["pdo"]["password"]);
	}
	catch (PDOException $e)
	{
    	exit;
	}	
	//Set Today's Date and Current Time
	$dateTime = date("Y-m-d H:i:s");
	
	require_once "geoip.inc";
	$gi = geoip_open("GeoIP.dat", GEOIP_STANDARD);
	
	//Add banned IP to database
	function addIp($ip)
	{
		global $db;
		global $dateTime;
		
		$ip_details = lookupIpDetails($ip);
		
		$stmt = $db->prepare("INSERT INTO `banned_ips` (`ip`, `hostname`, `iso`, `date_time`) VALUES (?, ?, ?, ?)");
		$stmt->execute(array($ip, $ip_details["hostname"], $ip_details["country"], $dateTime));
	}
	
	//Lookup the country and hostname details of an IP address
	function lookupIpDetails($ip)
	{
		global $gi;
		
		$iso = geoip_country_code_by_addr($gi, $ip);
		$hostname = gethostbyaddr($ip);
		return array("country" => $iso, "hostname" => $hostname);
	}
	
	//Gets a list of all ip addresses that have been banned
	function getAllIps()
	{
		global $db;
		
		$stmt = $db->prepare("SELECT * FROM `banned_ips`");
		$stmt->execute();
		$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $result;
	}
	
	//Gets a list of countries along with co-ordinates to publish to the map
	function getCountries($args)
	{
		$countries = array();
		$country_coords = array();
		$ignore = array("AP", "A1", "A2", "EU", "O1", "XX");
		
		foreach($args as $arg)
		{
			if(!in_array($arg["iso"], $countries) AND !in_array($arg["iso"], $ignore) AND !empty($arg["iso"]))
			{
				array_push($countries, $arg["iso"]);
			}
		}
		
		foreach($countries as $country)
		{
			$details = getCoords($country);
			$cc = array("iso" => $country, "lat" => $details["lat"], "lng" => $details["lng"]);
			array_push($country_coords, $cc);
		}
		
		sort($country_coords);
		return $country_coords;
	}
	
	//Gets co-ordinates of a country (capital city) based on it's ISO 3166-1 country code
	function getCoords($iso)
	{
		global $db;
		
		$stmt = $db->prepare("SELECT * FROM `countries` WHERE `iso` = ?");
		$stmt->execute(array($iso));
		$result = $stmt->fetch(PDO::FETCH_ASSOC);
		return $result;
	}
	
	//Get top X amount of countries that have been banned
	function topXCountries($amount)
	{
		global $db;
		
		$countries = array();
		$IPs = getAllIps();
		
		foreach($IPs as $ip)
		{
			$iso = $ip["iso"];
			$countries[$iso] = $countries[$iso] + 1;
		}
		arsort($countries);
		return array_slice($countries, 0, $amount);
	}
?>
