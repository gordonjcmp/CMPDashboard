<?php
//Error reporting
showErrors();


//From Google Dev (https://console.developers.google.com)
//Client ID
function getClientID()
{
	return '1030667579263-t47uhep8eut2s7lg6i4m6hqtbgi0l93r.apps.googleusercontent.com';
}
//Service email address
function getAcctName()
{
	return '1030667579263-t47uhep8eut2s7lg6i4m6hqtbgi0l93r@developer.gserviceaccount.com';
}
//Application Name
function getAppName()
{
	return "CMP-Analytics";
}


//File locations
//.p12 file location
function getKeyFile()
{
	return './CMP-analytics-f8f1f649c645.p12';
}
//Google API path (include trailing /)
function getAPIPath()
{
	return './google-api/';
}

function showErrors()
{
	error_reporting(E_ALL);
	ini_set('display_errors', '1');
}


/* Google Analytics accounts, easiest way to get them is from https://ga-dev-tools.appspot.com/explorer/ */

function getAccounts()
{
	$accounts = array();
	$accounts["CMOA"] = "ga:53193816";
	$accounts["CSC"] = "ga:12575410";
	$accounts["CMNH"] = "ga:86907168";
	$accounts["AWM"] = "ga:30663551";
	$accounts["CMP"] = "";
	
	return $accounts;
}

/* returns an array of colors for use in series plots */
function getColorScheme()
{
	$colors = array();

	
	//Light blue
	array_push($colors, "rgba(151,187,205,1)");
	
	//light green
	array_push($colors, "rgba(151,205,187,1)");

	//light red
	array_push($colors, "rgba(205,151,151,1)");

	//light purple
	array_push($colors, "rgba(205,151,205,1)");

	
	return $colors;

}

function insertScripts()
{
?>
<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">

<script src="jquery/jquery-1.11.2.min.js"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>
<script src="highcharts/js/highcharts.js"></script>

<?php
}




?>