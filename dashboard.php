<?php

require_once "highcharts.php";

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

function getCharts()
{
$charts = array();
$colors = getColorScheme();
$data = array();

$file = fopen("dashboard.csv","r");
while (!feof($file))
{
	array_push($data, fgetcsv($file));
}
fclose($file);	

$inverted = invertData($data);
$bar = new Highchart('column');
$bar->addCategories($inverted[0]);
$bar->addSeries($inverted[1],'AWM', $colors[3]);
$bar->addSeries($inverted[2],'CSC', $colors[2]);
$bar->addSeries($inverted[3],'OAK', $colors[1]);
$bar->addSeries($inverted[4],'Total', $colors[0], 'spline', '', '', 1);
$charts["admissions"] = $bar->toChart("#admissions");

$data = array();
$file = fopen("EndowmentTop.csv","r");
while (!feof($file))
{
	array_push($data, fgetcsv($file));
}
fclose($file);

$temprest = array();
$file = fopen("temprest.csv", "r");
while (!feof($file))
{
	array_push($temprest, fgetcsv($file));
}
fclose($file);
$inverted = invertData($data);
$invertedtemprest = invertData($temprest);

$bar = new Highchart('column');
$bar->addCategories($inverted[0]);
$bar->addDrilldown($invertedtemprest[1], 'temprest');
$bar->addSeries($inverted[1],'Temporarily Restricted', $colors[3], '', '', 'temprest');
$bar->addSeries($inverted[2],'Permanently Restricted', $colors[2]);
$bar->addSeries($inverted[3],'Unrestricted', $colors[1]);
$bar->addSeries($inverted[4],'Total', $colors[0], 'spline', '', '', 1);
$charts["endowment"] = $bar->toChart("#endowment");

$data = array();
$file = fopen("HeadCountTop.csv","r");
while (!feof($file))
{
	array_push($data, fgetcsv($file));
}
fclose($file);	

$inverted = invertData($data);
$bar = new Highchart('column');
$bar->setYAxisLabel('No. of employees');
$bar->addYAxis('Total', 500, 1200, 100);
$bar->addCategories($inverted[0]);
$bar->addSeries($inverted[1],'AWM', $colors[3]);
$bar->addSeries($inverted[2],'CSC', $colors[2]);
$bar->addSeries($inverted[3],'CMA', $colors[1]);
$bar->addSeries($inverted[4],'CMNH', $colors[1]);
$bar->addSeries($inverted[5],'Total', $colors[0], 'spline',1,'',1);
$charts["headcount"] = $bar->toChart("#headcount");


return $charts;

}

function invertData($data)
{
	$newData = array();
	$cols = 0;
	foreach($data[0] as $d)
	{
		array_push($newData, array());
		$cols++;
	}
	$i = 0;
	foreach($data as $d)
	{
		for($j = 0; $j < $cols; $j++)
		{
			$newData[$j][$i] = $d[$j];
		
		}
		$i++;
	}
	return $newData;
}

function hours()
{

	$app = array("am","pm");
	$res = array();
	for($i = 0; $i < 2; $i++)
	{
		for($j = 0; $j < 12; $j++)
		{
			if($j == 0)
			{
				array_push($res,"12 " . $app[$i]);
			}
			else
			{
				array_push($res,$j . " " . $app[$i]);
			}
		}
	
	}
	return $res;
}


function setupCharts($cnames, $ctitles)
{
	$i = 0;
	foreach($cnames as $cname)
	{
		setupChart($cname, $ctitles[$i]);
		$i ++;
	}

}

function setupChart($cname, $ctitle)
{
?>

<div class="col-xs-12 col-md-4">
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title"><?php print $ctitle;?></h3>
		</div>
		<div class="panel-body">
			<div class='chart-holder' id="<?php print $cname;?>">
			</div>
		</div>
	</div>
</div>

<?php
}

?>