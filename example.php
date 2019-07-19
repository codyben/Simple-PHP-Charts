<?php
//EXAMPLE FILE
namespace codyben;

$time_start = microtime(true);

require_once 'SimplePHPChart.php';


$chart = new SimplePHPChart(1000, 1000); //create a 1000px X 1000px chart

for($i = 0; $i < 600; $i++) //place 600 points on it -- for fun
{
	$chart->setPoint(mt_rand(-500,200), mt_rand(-250, 250));
}

imagepng($chart->makeChart(), "test.png"); 
// makeChart() returns a resource, so its up to you to decide how you want to handle it
// https://www.php.net/manual/en/function.imagepng.php
// alternatives are listed at that link, too

/* begin timing output */
$time_end = microtime(true);

$execution_time = ($time_end - $time_start);

echo $execution_time." seconds.";