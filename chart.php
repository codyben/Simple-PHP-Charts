<?php
require('Simple-PHP-Chart.php');

$dataPointsX =
array
	(
		-1,2,
		3,-1
	);
$dataPointsY =
array
	(
		-1,4,
		7,0
	);
$dataRange = 
array
	(
		//X's run left to right
		//Y's run top to bottom
		'startX'=> -10,
		'startY'=> 8,
		'endX'=> 18,
		'endY'=> -5
	);	
$gridLines = FALSE;
$chartSize =
array
	(
		'x'=>500,
		'y'=>500
	);

$tickMarks = TRUE;


$im = imagecreatetruecolor($chartSize['x'], $chartSize['y']);

$colorOptions = array
(
	'colorTickY' => imagecolorallocate($im, 255, 255, 255), //white
	'colorTickX' => imagecolorallocate($im, 255, 255, 255), //white
	'colorAxisY' => imagecolorallocate($im, 255,215,0), //gold
	'colorAxisX' => imagecolorallocate($im, 255, 255, 255), //gold
	'colorGraphBackground' => imagecolorallocate($im, 255, 255, 0), //black
	'colorDataPoints' => imagecolorallocate($im, 0,128,0) //green

);
createChart($im, $colorOptions, $dataPointsX,$dataPointsY, $dataRange, $gridLines, $chartSize, $tickMarks);