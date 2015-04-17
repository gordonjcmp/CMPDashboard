<?php

require_once "analytics.php";
require_once "highcharts.php";
require_once 'cache.php';


function getAccounts()
{
	$accounts = array();
	$accounts["CMOA"] = "ga:53193816";
	$accounts["CSC"] = "ga:12575410";
	$accounts["CMNH"] = "ga:19917087"; //"ga:86907168";
	$accounts["AWM"] = "ga:30663551";
	$accounts["CMP"] = "";
	
	return $accounts;
}


function GDate($time = '')
{
	if($time == '')	return date('Y-m-d');
	return date('Y-m-d', $time);
}

function fromGDateHour($gTime)
{
	$year = substr($gTime,0,4);
	$mon = substr($gTime, 4, 2);
	$day = substr($gTime, 6,2);
	$hr = substr($gTime, 8,2);
	
	return $year . "-" . $mon . "-" . $day . " " . $hr . ":00";
}

function getData($analytics, $from = '2008-10-01', $to = '', $cache=true)
{
	if($to == '') $to = GDate();
	
	//check cache for dataset
	if($cache)
	{
		$cData = loadFromCache("COMP-ext" . "@" . $from . "@" . $to);
		if(!empty($cData)) return unserialize ( $cData );
	}
	
	$data = array();
	$data["hist"] = array();
	$acct = getAccounts();
	foreach($acct as $aname=>$aval)
	{

		try
		{
			$data["hist-users"][$aname] = invertData(runQuery($analytics, $aval,$from,$to,"ga:users","ga:date","",'10000')->getRows());
		}
		catch (Exception $e)	
		{ }
		
	}
	//invertData();
		if($cache)
	{
		$cData = serialize ($data);
		storeInCache("COMP-ext" . "@" . $from . "@" . $to, $cData);
	}
	
	return $data;

}

function getAnalytics()
{
	$client = getClient();
	$token = Authenticate($client);
	$analytics = new Google_Service_Analytics($client);
	return $analytics;
}

function addAnaChart($charts)
{
$analytics = getAnalytics();

$data = getData($analytics);
//Compare Views
$chart = new Highstock();
$c = 0;
$hist = $data["hist-users"];

foreach($hist as $dname=>$dval)
{
	$chart->addSeries($dval[0],$dval[1],$dname,$colors[$c]);
	$c++;
}

$chart->addLegend();
$charts["hist-users"] = $chart->toChart("#hist");

return $charts;

}














?>