<?php
	$get_addr="http://localhost/wp/scpsa/api/?src=biblioteca&ano=2018";
	$ch = curl_init($get_addr);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	$page = curl_exec($ch);
	$evento = json_decode($page,true);



require_once 'inc/phplot/phplot.php';


$data = array(
  array('', 1800,   5), array('', 1810,   7), array('', 1820,  10),
  array('', 1830,  13), array('', 1840,  17), array('', 1850,  23),
  array('', 1860,  31), array('', 1870,  39), array('', 1880,  50),
  array('', 1890,  63), array('', 1900,  76), array('', 1910,  92),
  array('', 1920, 106), array('', 1930, 123), array('', 1940, 132),
  array('', 1950, 151), array('', 1960, 179), array('', 1970, 203),
  array('', 1980, 227), array('', 1990, 249), array('', 2000, 281),
);

$plot = new PHPlot(1600, 600);
$plot->SetImageBorderType('plain');

$plot->SetPlotType('bars');
$plot->SetDataType('text-data');
$plot->SetLegend('leg'); // gera as legendas do grafico
$plot->SetDataValues($evento);

# Main plot title:
$plot->SetTitle('US Population, in millions');

# Make sure Y axis starts at 0:
$plot->SetPlotAreaWorld(NULL, 0, NULL, NULL);

$plot->DrawGraph();