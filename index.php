<?php


function showErrors()
{
	error_reporting(E_ALL);
	ini_set('display_errors', '1');
}

showErrors();

require_once 'dashboard.php';

require_once 'addAnalytics.php';


$charts = getCharts();

$charts = addAnaChart($charts); //Add the analytics chart

?>

<!DOCTYPE html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php insertScripts() ?>
	<script>
		$( document ).ready(function($) {

										
			Highcharts.setOptions({
    lang: {
        thousandsSep: ','
    }
});
				<?php
				

			foreach($charts as $c)
			{
				print $c;
			}
			?>
		
		});
		

	</script>
	<style>
	ul{
		list-style-type: none;
	}
	.chart-holder
	{
		position:relative;
		margin-left: 1%;
		margin-top:1%;
		width:98%;
		height:98%;
	}
	.legend
	{
		position:absolute;
		top:1%;
		right:1%;
	}
	.legend span
	{
		float:right;
		margin-bottom: 5px;
	}
	.main-panel
	{
		padding-left: 1%;
		padding-top:1%;
		width:100%;
	}
	.panel-body
	{
	position:relative;
	}
	</style>
</head>
<body>
	<ul id='main-nav' class="nav nav-tabs">
		<li id='CMPtab' role="presentation" class="active"><a href="#">Central</a></li>
	</ul>
	
			
	<div id='Panel' class='main-panel container'>
		<?php 	
		setupCharts(
			array("admissions","endowment","headcount","philanthropy","membership"),
			array("Admissions","Endowment","Head Count","Philanthropy","Membership"));
		?>

	</div>
	
</body>