<?php
//Basic PHP Charts
//Like, really basic

function createChart($im, Array $colorOptions, Array $dataPointsX, Array $dataPointsY, Array $dataRange, bool $gridLines, Array $chartSize, bool $tickMarks, String $imageName = 'chart.png')
{
	//extract color options from array :]
	extract($colorOptions);
	//Set the background
	$background = imagefill($im, 0, 0, $colorGraphBackground);
	//Define points
	$dataStartX = $dataRange['startX'];
	$dataStartY = $dataRange['startY'];
	$dataEndX = $dataRange['endX'];
	$dataEndY = $dataRange['endY'];
	$xPX = $chartSize['x'];
	$yPX = $chartSize['y'];
	//Set Domain (total size of x-axis)
	$domain = abs($dataStartX) + abs($dataEndX);
	//Since we cannot graph 1-1, we find a scale with which we can translate a '1' to actually mean '1' unit on the graph
	$scaleX = ($xPX/$domain);
	//Set Range (total size of Y-axis)
	$range = abs($dataStartY) + abs($dataEndY);
	//Since we cannot graph 1-1, we find a scale with which we can translate a '1' to actually mean '1' unit on the graph
	$scaleY = ($yPX/$range);
	//Divide both x and y to find what would be the "perfect" origin 
	$originX =  $xPX/2;
	$originY = $yPX/2;
	//SHIFT Y-AXIS DEPENDING ON DOMAIN
	$shiftX = $scaleX*abs($dataStartX);
	$AxisY = imageline($im, $shiftX , 0 , $shiftX, $yPX , $colorAxisX);
	//SHIFT X-Axis DEPENDING ON RANGE
	$shiftY = $scaleY*abs($dataStartY);
	$AxisX = imageline($im, 0 , $shiftY , $xPX , $shiftY, $colorAxisX);
	
	//END AXIS

	//CREATE TICK MARKS
	if($tickMarks === TRUE)
	{
		//DRAW A SHORT VERTICAL LINE TO BE A TICK MARK
		//we multiply by the scale and the domain to get the total distance the ticks need to cross
		$tickX = 0;
		$tickY = 0;
		while($tickX <= ($xPX))
		{
			//BEGIN X TICK MARKS
			$tickSizeX = $scaleY/6;
			imageline($im, $tickX, 0-$tickSizeX+$shiftY, $tickX, 0+$tickSizeX+$shiftY, $colorTickX);
			$tickX = $tickX + $scaleX;
			//END X TICK MARKS
		}
		while($tickY <= ($yPX))
		{
			$tickSizeY = $scaleY/6;
			imageline($im, 0-$tickSizeY+$shiftX, $tickY, 0+$tickSizeY+$shiftX, $tickY, $colorTickY);
			$tickY = $tickY + $scaleY;
		}
	}
	//END TICK MARKS

	//PLOT DATA POINTS
	if(count($dataPointsY)===count($dataPointsX))
	{
		$z =0;
		while( $z <=count($dataPointsX)-1)
		{
			imagefilledellipse($im, $dataPointsX[$z]*$scaleX+$shiftX, $dataPointsY[$z]*$scaleY*(-1)+$shiftY, 10, 10, $colorDataPoints);
			$z++;
		}
	}
	Header('Content-type: image/png');
	Header('Content-Disposition: inline; filename="'.$imageName.'"');
	return imagepng($im);
	//free up memory and exit script
	imagedestroy($im);
	exit();
	

}
// END FUNCTIONS //
